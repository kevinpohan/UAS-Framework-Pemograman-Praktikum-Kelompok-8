<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\PriceCache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StockPriceService
{
    // Konfigurasi Finnhub (untuk harga real-time)
    private $finnhubApiKey;
    private $finnhubBaseUrl;
    private $finnhubProvider = 'finnhub';

    // Konfigurasi Twelve Data (untuk chart dan movers)
    private $twelveDataApiKey;
    private $twelveDataBaseUrl;
    private $twelveDataProvider = 'twelvedata';

    public function __construct()
    {
        $this->finnhubApiKey = config('services.finnhub.api_key');
        $this->finnhubBaseUrl = config('services.finnhub.base_url', 'https://finnhub.io/api/v1');

        // Ambil kunci API Twelve Data
        $this->twelveDataApiKey = config('services.twelvedata.api_key');
        $this->twelveDataBaseUrl = config('services.twelvedata.base_url', 'https://api.twelvedata.com');
    }

    // getCurrentPrice: TETAP MENGGUNAKAN FINNHUB (seperti permintaan user)
    public function getCurrentPrice($symbol)
    {
        $stock = Stock::where('symbol', $symbol)->first();
        if (!$stock) return null;

        $cache = $stock->priceCache;
        // JIKA ADA CACHE
        if ($cache && $cache->fetched_at->addMinutes(5)->isAfter(now())) {
            $previousClose = $cache->raw_response['pc'] ?? null;
            $volume = $cache->raw_response['v'] ?? null; // <-- MENGAMBIL VOLUME DARI CACHE
            return ['current_price' => $cache->price, 'previous_close' => $previousClose, 'volume' => $volume]; // <-- MENGEMBALIKAN VOLUME
        }

        // Memanggil API Finnhub
        $response = Http::get($this->finnhubBaseUrl . '/quote', [
            'symbol' => $symbol,
            'token' => $this->finnhubApiKey,
        ]);

        if ($response && $response->successful()) {
            $data = $response->json();
            $price = $data['c'] ?? null;
            $previousClose = $data['pc'] ?? null;
            $volume = $data['v'] ?? null; // <-- MENGAMBIL VOLUME DARI RESPONSE API

            if ($price && $price > 0) {
                PriceCache::updateOrCreate(
                    ['stock_id' => $stock->id],
                    ['price' => $price, 'fetched_at' => now(), 'raw_response' => $data]
                );
                return ['current_price' => $price, 'previous_close' => $previousClose, 'volume' => $volume]; // <-- MENGEMBALIKAN VOLUME
            }
        }

        Log::error("[{$this->finnhubProvider}] API Error for $symbol: " . ($response ? $response->body() : 'No response'));

        // JIKA GAGAL DAN MENGGUNAKAN CACHE FALLBACK
        if ($cache) {
            $previousClose = $cache->raw_response['pc'] ?? null;
            $volume = $cache->raw_response['v'] ?? null; // <-- MENGAMBIL VOLUME DARI CACHE FALLBACK
            return ['current_price' => $cache->price, 'previous_close' => $previousClose, 'volume' => $volume]; // <-- MENGEMBALIKAN VOLUME
        }

        return null;
    }

    /**
     * getMarketMovers: Mengambil Top 3 Gainers dan Losers dari database PriceCache lokal.
     */
    public function getMarketMovers()
    {
        // 1. Ambil semua saham yang memiliki data PriceCache
        $stocksWithPrices = Stock::with('priceCache')
            ->whereHas('priceCache', function ($query) {
                // Pastikan ada data cache yang harganya > 0
                $query->where('price', '>', 0);
            })->get();

        // 2. Hitung persentase perubahan untuk setiap saham
        $calculatedStocks = $stocksWithPrices->map(function ($stock) {
            $priceCache = $stock->priceCache;
            $currentPrice = $priceCache->price ?? 0;
            // Ambil harga penutupan sebelumnya dari raw_response (Finnhub 'pc')
            $previousClosePrice = $priceCache->raw_response['pc'] ?? 0;

            $percentChange = 0;
            if ($currentPrice > 0 && $previousClosePrice > 0) {
                $change = $currentPrice - $previousClosePrice;
                $percentChange = ($change / $previousClosePrice) * 100;
            }

            return [
                'symbol' => $stock->symbol,
                'change_percent' => $percentChange,
            ];
        })->filter(function ($stock) {
            // Filter yang memiliki perubahan, meskipun 0, agar tidak menampilkan N/A di Home
            return $stock['symbol'] !== 'N/A';
        });

        // 3. Sortir dan batasi menjadi Top 3 Gainers
        $topGainers = $calculatedStocks
            ->sortByDesc('change_percent')
            ->take(3)
            ->values()
            ->toArray();

        // 4. Sortir dan batasi menjadi Top 3 Losers
        $topLosers = $calculatedStocks
            ->sortBy('change_percent')
            ->take(3)
            ->values()
            ->toArray();

        return [
            'gainers' => $topGainers,
            'losers' => $topLosers,
        ];
    }

    // Metode fetchMoverData yang lama telah dihapus karena sekarang menggunakan DB

    // searchStocks: TETAP MENGGUNAKAN FINNHUB
    public function searchStocks($query)
    {
        // Call Finnhub API directly
        $response = Http::get($this->finnhubBaseUrl . '/search', [
            'q' => $query,
            'token' => $this->finnhubApiKey,
        ]);

        if ($response && $response->successful()) {
            return $response->json();
        }

        Log::error("[{$this->finnhubProvider}] Search API Error for $query: " . ($response ? $response->body() : 'No response'));
        return null;
    }

    // getHistoricalPrices: MENGGUNAKAN TWELVE DATA
    public function getHistoricalPrices($symbol, $resolution = '1min', $from = null, $to = null)
    {
        $intervalMap = [
            '1m' => '1min',
            'D' => '1day',
            'M' => '1month',
        ];

        $interval = $intervalMap[$resolution] ?? '1min';

        $dateTo = $to ? date('Y-m-d H:i:s', $to) : now()->format('Y-m-d H:i:s');
        $dateFrom = $from ? date('Y-m-d H:i:s', $from) : now()->subDays(5)->format('Y-m-d H:i:s');

        $response = Http::get($this->twelveDataBaseUrl . '/time_series', [
            'symbol' => $symbol,
            'interval' => $interval,
            'start_date' => $dateFrom,
            'end_date' => $dateTo,
            'outputsize' => 30,
            'apikey' => $this->twelveDataApiKey,
            'timezone' => 'UTC',
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['values']) && is_array($data['values'])) {

                $c = [];
                $t = [];

                foreach ($data['values'] as $value) {
                    $c[] = (float) $value['close'];
                    $t[] = strtotime($value['datetime']);
                }

                return [
                    'c' => $c,
                    't' => $t,
                    's' => 'ok',
                ];
            }
        }

        Log::error("[{$this->twelveDataProvider}] Candle API Error for $symbol: " . ($response->body()));
        return null;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Services\StockPriceService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class HomeController extends Controller
{
    protected $priceService;

    public function __construct(StockPriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    public function index()
    {
        // 1. Ambil Market Movers (Top Gainers/Losers)
        $marketMovers = $this->priceService->getMarketMovers();

        // 2. Ambil Featured Stocks (Top 8 Saham)
        // Ambil SEMUA saham yang ingin ditampilkan untuk perhitungan Top 8
        $stocks = Stock::with('priceCache')->get();

        // Hitung harga, persentase perubahan, dan tandai Top 8
        $stocks = $stocks->map(function ($stock) {
            $priceData = $this->priceService->getCurrentPrice($stock->symbol);

            $stock->current_price = $priceData['current_price'] ?? null;
            $stock->previous_close_price = $priceData['previous_close'] ?? null;

            $stock->percent_change = 0;
            if (isset($stock->current_price) && isset($stock->previous_close_price) && $stock->previous_close_price > 0) {
                $change = $stock->current_price - $stock->previous_close_price;
                $stock->percent_change = ($change / $stock->previous_close_price) * 100;
            }

            $stock->is_top = false;
            return $stock;
        });

        // Urutkan dan ambil Top 8
        $sortedStocks = $stocks->sortByDesc('percent_change');

        $count = 0;
        $featuredStocks = new Collection();
        foreach ($sortedStocks as $stock) {
            if ($count < 8) {
                $stock->is_top = true;
                $featuredStocks->push($stock);
                $count++;
            }
            // Hentikan setelah 8 saham diidentifikasi dan ditambahkan ke featuredStocks
            if ($count >= 8) {
                break;
            }
        }

        // Kirim hanya 8 saham teratas ke view
        return view('home', [
            'marketMovers' => $marketMovers,
            'stocks' => $featuredStocks,
        ]);
    }
}

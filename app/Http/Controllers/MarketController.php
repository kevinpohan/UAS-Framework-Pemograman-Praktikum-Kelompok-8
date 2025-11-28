<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\PriceCache;
use App\Models\Portfolio;
use App\Models\Transaction;
use App\Services\StockPriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class MarketController extends Controller
{
    protected $priceService;

    public function __construct(StockPriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    public function index()
    {
        // 1. Ambil SEMUA saham yang visible beserta data priceCache-nya
        $stocks = Stock::where('is_visible', true)
            ->with('priceCache')
            ->get();

        // 2. Hitung harga saat ini dan persentase perubahan untuk setiap saham
        $stocks = $stocks->map(function ($stock) {
            // Panggil service untuk mendapatkan harga real-time
            $priceData = $this->priceService->getCurrentPrice($stock->symbol);

            if ($priceData) {
                $stock->current_price = $priceData['current_price'] ?? null;
                $stock->previous_close_price = $priceData['previous_close'] ?? null;
                $stock->volume = $priceData['volume'] ?? 0;
            }

            // Hitung perubahan persentase (Change Percentage)
            $stock->percent_change = 0;
            if (isset($stock->current_price) && isset($stock->previous_close_price) && $stock->previous_close_price > 0) {
                $change = $stock->current_price - $stock->previous_close_price;
                $stock->percent_change = ($change / $stock->previous_close_price) * 100;
            }

            $stock->is_top = false;

            return $stock;
        });

        // 3. Urutkan koleksi berdasarkan 'percent_change' (tertinggi ke terendah)
        $sortedStocks = $stocks->sortByDesc('percent_change');

        $count = 0;
        $finalStocks = new Collection();
        foreach ($sortedStocks as $stock) {
            if ($count < 9) {
                $stock->is_top = true;
                $count++;
            }
            $finalStocks->push($stock);
        }

        // Pass SEMUA saham yang visible ke view
        return view('market.index', ['stocks' => $finalStocks]);
    }

    public function show(Stock $stock)
    {
        $priceData = $this->priceService->getCurrentPrice($stock->symbol);

        // Ekstrak harga sebagai number dari array
        $currentPrice = $priceData['current_price'] ?? 0;
        $previousClosePrice = $priceData['previous_close'] ?? 0;

        return view('market.show', compact('stock', 'currentPrice', 'previousClosePrice'));
    }

    public function buy(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.0001',
        ]);

        $quantity = $request->quantity;
        $priceData = $this->priceService->getCurrentPrice($stock->symbol);
        $currentPrice = $priceData['current_price'] ?? null; // Ambil nilai numerik 'current_price'

        if (!$currentPrice) {
            return back()->with('error', 'Could not fetch current price for this stock.');
        }

        $total = $quantity * $currentPrice;
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->balance < $total) {
            return back()->with('error', 'Insufficient balance to complete this purchase.');
        }

        DB::transaction(function () use ($user, $stock, $quantity, $currentPrice, $total) {
            // Create transaction
            $transaction = $user->transactions()->create([
                'stock_id' => $stock->id,
                'type' => 'buy',
                'qty' => $quantity,
                'price' => $currentPrice,
                'total' => $total,
                'status' => 'completed',
            ]);

            // Update user balance
            $user->decrement('balance', $total);

            // Update portfolio
            $portfolio = $user->portfolios()->firstOrCreate(
                ['stock_id' => $stock->id],
                ['quantity' => 0, 'avg_price' => 0]
            );

            $newQuantity = $portfolio->quantity + $quantity;
            $newAvgPrice = (($portfolio->quantity * $portfolio->avg_price) + ($quantity * $currentPrice)) / $newQuantity;

            $portfolio->update([
                'quantity' => $newQuantity,
                'avg_price' => $newAvgPrice,
            ]);
        });

        return redirect()->route('portfolio.index')->with('success', 'Stock purchased successfully!');
    }


    // Method untuk jual saham
    public function sell(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.0001',
        ]);

        $quantity = $request->quantity;

        // EKSTRAKSI HARGA DARI ARRAY SEBELUM DIGUNAKAN DI PERKALIAN
        $priceData = $this->priceService->getCurrentPrice($stock->symbol);
        $currentPrice = $priceData['current_price'] ?? null;

        if (!$currentPrice) {
            return back()->with('error', 'Could not fetch current price for this stock.');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek apakah user memiliki saham ini dan jumlahnya cukup
        $portfolio = $user->portfolios()->where('stock_id', $stock->id)->first();

        if (!$portfolio || $portfolio->quantity < $quantity) {
            return back()->with('error', 'Insufficient shares to complete this sale.');
        }

        $total = $quantity * $currentPrice;

        DB::transaction(function () use ($user, $stock, $quantity, $currentPrice, $total, $portfolio) {
            // Create transaction
            $transaction = $user->transactions()->create([
                'stock_id' => $stock->id,
                'type' => 'sell',
                'qty' => $quantity,
                'price' => $currentPrice,
                'total' => $total,
                'status' => 'completed',
            ]);

            // Update user balance
            $user->increment('balance', $total);

            // Update portfolio
            $newQuantity = $portfolio->quantity - $quantity;

            if ($newQuantity == 0) {
                // Jika jumlah saham menjadi 0, hapus dari portfolio
                $portfolio->delete();
            } else {
                // Jika masih ada saham, update jumlahnya
                $portfolio->update([
                    'quantity' => $newQuantity,
                ]);
            }
        });

        return redirect()->route('portfolio.index')->with('success', 'Stock sold successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return response()->json([]);
        }

        // 1. Mencari di database lokal
        $stocks = Stock::where('symbol', 'LIKE', "%{$query}%")
            ->orWhere('name', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        // 2. Mengambil harga dan menghitung persentase perubahan untuk setiap saham
        $results = $stocks->map(function ($stock) {

            $priceData = $this->priceService->getCurrentPrice($stock->symbol);

            $currentPrice = 0;
            $previousClosePrice = 0;

            if (is_array($priceData)) {
                $currentPrice = $priceData['current_price'] ?? 0;
                $previousClosePrice = $priceData['previous_close'] ?? 0;
            }

            $percentChange = 0;
            if ($currentPrice > 0 && $previousClosePrice > 0) {
                $change = $currentPrice - $previousClosePrice;
                $percentChange = ($change / $previousClosePrice) * 100;
            }

            return [
                'id' => $stock->id,
                'symbol' => $stock->symbol,
                'name' => $stock->name,
                'current_price' => $currentPrice,
                'previous_close_price' => $previousClosePrice,
                'percent_change' => $percentChange,
            ];
        })->values();

        return response()->json($results);
    }
}

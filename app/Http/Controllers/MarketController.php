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

class MarketController extends Controller
{
    protected $priceService;

    public function __construct(StockPriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    public function index()
    {
        $stocks = Stock::with('priceCache')->get();

        foreach ($stocks as $stock) {
            $priceData = $this->priceService->getCurrentPrice($stock->symbol);
            $stock->current_price = $priceData['current_price'] ?? null;
            $stock->previous_close_price = $priceData['previous_close'] ?? null;
        }

        return view('market.index', compact('stocks'));
    }


    public function search(Request $request)
    {
        $q = $request->q;

        if (!$q) {
            return response()->json([]);
        }

        $results = Stock::where('symbol', 'like', "%$q%")
            ->orWhere('name', 'like', "%$q%")
            ->get(['id', 'symbol', 'name']);

        foreach ($results as $stock) {
            $priceData = $this->priceService->getCurrentPrice($stock->symbol);
            $stock->current_price = $priceData['current_price'] ?? null;
            $stock->previous_close_price = $priceData['previous_close'] ?? null;
        }

        return response()->json($results);
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
        $currentPrice = $priceData['current_price'] ?? null;

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

    public function sell(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.0001',
        ]);

        $quantity = $request->quantity;

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
}

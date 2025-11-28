<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Stock;
use App\Services\StockPriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    protected $priceService;

    public function __construct(StockPriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $portfolios = $user->portfolios()->with('stock')->get();
        $totalValue = 0;
        $totalCost = 0;

        foreach ($portfolios as $portfolio) {
            $priceData = $this->priceService->getCurrentPrice($portfolio->stock->symbol);

            // Ekstrak harga numerik yang sebenarnya
            $currentPrice = $priceData['current_price'] ?? null;

            // Gunakan harga yang diekstrak, atau fallback ke avg_price
            $portfolio->current_price = $currentPrice ?: $portfolio->avg_price;

            // Lanjutkan perhitungan menggunakan harga yang sudah menjadi numerik
            $portfolio->current_value = $portfolio->quantity * $portfolio->current_price;
            $portfolio->profit_loss = $portfolio->current_value - ($portfolio->quantity * $portfolio->avg_price);

            $totalValue += $portfolio->current_value;
            $totalCost += $portfolio->quantity * $portfolio->avg_price;
        }

        $totalProfitLoss = $totalValue - $totalCost;

        return view('portfolio.index', compact('portfolios', 'totalValue', 'totalProfitLoss'));
    }
}

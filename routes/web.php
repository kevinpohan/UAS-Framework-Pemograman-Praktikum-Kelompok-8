<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StockController as AdminStockController;
use App\Http\Controllers\Admin\TopUpController as AdminTopUpController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\TransactionController;
use App\Models\Stock;
use App\Services\StockPriceService;
use App\Http\Controllers\Api\StockController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/', function (StockPriceService $priceService) {
    // Fetch limited stocks for display (e.g., first 10)
    $stocks = Stock::limit(8)->get();

    // Fetch Market Movers (Top Gainers/Losers)
    $marketMovers = $priceService->getMarketMovers();

    // Prepare prices for the limited stocks
    foreach ($stocks as $stock) {
        $priceData = $priceService->getCurrentPrice($stock->symbol);

        if ($priceData) {
            $stock->current_price = $priceData['current_price'] ?? null;
            $stock->previous_close_price = $priceData['previous_close'] ?? null;
        }
    }

    return view('home', compact('stocks', 'marketMovers'));
})->name('home');

require __DIR__ . '/auth.php';

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Market routes
    Route::get('/market', [MarketController::class, 'index'])->name('market.index');
    Route::get('/market/search', [MarketController::class, 'search'])->name('market.search');
    Route::get('/market/{stock}', [MarketController::class, 'show'])->name('market.show');
    Route::post('/market/{stock}/buy', [MarketController::class, 'buy'])->name('market.buy');
    Route::post('/market/{stock}/sell', [MarketController::class, 'sell'])->name('market.sell');

    // Portfolio routes
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

    // Transaction routes
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/export/excel', [TransactionController::class, 'exportExcel'])->name('transactions.export.excel');
    Route::get('/transactions/export/pdf', [TransactionController::class, 'exportPdf'])->name('transactions.export.pdf');

    // Top-up routes
    Route::get('/topup', [TopUpController::class, 'create'])->name('topup.create');
    Route::post('/topup', [TopUpController::class, 'store'])->name('topup.store');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // --- NEW: Dashboard Transaction Export Routes ---
    Route::get('/dashboard/export/excel', [DashboardController::class, 'exportExcel'])->name('dashboard.export.excel');
    Route::get('/dashboard/export/pdf', [DashboardController::class, 'exportPdf'])->name('dashboard.export.pdf');


    // Stocks
    Route::get('/stocks/search', [AdminStockController::class, 'search'])->name('stocks.search');
    Route::get('/stocks/export/excel', [AdminStockController::class, 'exportExcel'])->name('stocks.export.excel');
    Route::get('/stocks/export/pdf', [AdminStockController::class, 'exportPdf'])->name('stocks.export.pdf');
    Route::resource('stocks', AdminStockController::class);
    // Users
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // Top-ups
    Route::get('/topups', [AdminTopUpController::class, 'index'])->name('topups.index');
    Route::post('/topups/{topup}/approve', [AdminTopUpController::class, 'approve'])->name('topups.approve');
    Route::post('/topups/{topup}/reject', [AdminTopUpController::class, 'reject'])->name('topups.reject');
});

Route::get('/api/stock/{symbol}/chart', [StockController::class, 'getChart'])->name('api.stock.chart');

Route::get('/forecast', function () {
    return view('forecast');
})->name('forecast.index');

Route::get('/forecast/{symbol}', [StockController::class, 'forecast']);



Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

@extends('layouts.app')

@section('content')
@if(auth()->user()->isAdmin())
<div class="max-w-7xl mx-auto py-16 px-4">
    <div class="bg-gray-800 rounded-xl p-8 text-center">
        <i class="fas fa-lock text-6xl text-gray-500 mb-4"></i>
        <h2 class="text-3xl font-bold mb-4">Access Denied</h2>
        <p class="text-xl text-gray-400 mb-6">Admin users cannot access the portfolio view.</p>
        <a href="{{ route('admin.dashboard') }}" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
            Go to Admin Dashboard
        </a>
    </div>
</div>
@else
<section class="py-16 px-4 bg-gray-800">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold"><i class="fas fa-portfolio mr-3"></i>Portfolio</h2>
            <div class="text-right">
                <div class="text-2xl font-bold text-primary">${{ number_format($totalValue, 2) }}</div>
                <div class="{{ $totalProfitLoss >= 0 ? 'text-green-400' : 'text-red-400' }}">
                    @if($totalProfitLoss >= 0)
                    +${{ number_format($totalProfitLoss, 2) }}
                    @else
                    -${{ number_format(abs($totalProfitLoss), 2) }}
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-gray-900 rounded-xl p-6">
                    <h3 class="text-xl font-bold mb-4">Holdings</h3>
                    <div class="space-y-4">
                        @forelse($portfolios as $portfolio)
                        <div class="portfolio-item bg-gray-800 rounded-lg p-4 flex justify-between items-center">
                            <div>
                                <h4 class="font-bold">{{ $portfolio->stock->symbol }}</h4>
                                <p class="text-sm text-gray-400">{{ $portfolio->quantity }} shares</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <div class="font-bold">${{ number_format($portfolio->current_value, 2) }}</div>
                                    <div class="{{ $portfolio->profit_loss >= 0 ? 'text-green-400' : 'text-red-400' }} text-sm">
                                        @if($portfolio->profit_loss >= 0)
                                        +${{ number_format($portfolio->profit_loss, 2) }}
                                        @else
                                        -${{ number_format(abs($portfolio->profit_loss), 2) }}
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('market.show', $portfolio->stock) }}" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">
                                    <i class="fas fa-arrow-up mr-1"></i>Sell
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-box-open text-4xl mb-4"></i>
                            <p>No holdings yet. Start by buying some stocks!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-900 rounded-xl p-6">
                    <h3 class="text-xl font-bold mb-4">Account Balance</h3>
                    <div class="text-3xl font-bold text-primary mb-2">${{ number_format(Auth::user()->balance, 2) }}</div>
                    <div class="text-green-400 mb-4">Available for trading</div>
                    <a href="{{ route('topup.create') }}" class="w-full bg-primary hover:bg-blue-500 py-3 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Top-up Balance
                    </a>
                </div>

                <div class="bg-gray-900 rounded-xl p-6">
                    <h3 class="text-xl font-bold mb-4">Quick Stats</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span>Total Holdings</span>
                            <span>{{ $portfolios->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Average Cost</span>
                            <span>${{ $portfolios->avg('avg_price') ? number_format($portfolios->avg('avg_price'), 2) : '0.00' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Best Performer</span>
                            <span class="text-green-400">
                                @if($portfolios->count() > 0)
                                {{ $portfolios->sortByDesc('profit_loss')->first()->stock->symbol }}
                                @else
                                N/A
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection
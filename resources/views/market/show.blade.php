@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-gray-800 rounded-xl p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold">{{ $stock->symbol }}</h1>
                    <p class="text-xl text-gray-400">{{ $stock->name }}</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold text-green-400">${{ number_format($currentPrice ?? 0, 2) }}</div>

                    {{-- Menghitung Persentase Aktual --}}
                    @php
                    // Hitung perubahan harga
                    $prev = $previousClosePrice ?? 0;
                    $curr = $currentPrice ?? 0;

                    $change = $curr - $prev;
                    $percentChange = ($prev > 0) ? ($change / $prev) * 100 : 0;
                    $isPositive = $change >= 0;
                    @endphp

                    <div class="{{ $isPositive ? 'text-green-400' : 'text-red-400' }}">
                        {{ $isPositive ? '+' : '' }}{{ number_format($percentChange, 2) }}%
                    </div>

                </div>
            </div>

            <div class="bg-gray-900 rounded-lg p-6 mb-8 h-64 flex items-center justify-center">
                <div id="chart-container" class="w-full h-full">
                    <canvas id="stock-chart"></canvas>
                </div>
            </div>

            @auth
            @if(!Auth::user()->isAdmin())
            @php
            $userPortfolio = Auth::user()->portfolios()->where('stock_id', $stock->id)->first();
            @endphp

            @if($userPortfolio && $userPortfolio->quantity > 0)
            <div class="bg-gray-900 rounded-lg p-4 mb-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-bold">Your Holdings</h3>
                        <p class="text-sm text-gray-400">{{ $userPortfolio->quantity }} shares</p>
                        <p class="text-sm text-gray-400">Avg Price: ${{ number_format($userPortfolio->avg_price, 2) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-xl">${{ number_format($userPortfolio->quantity * $currentPrice, 2) }}</p>
                        @php
                        $profit = ($currentPrice - $userPortfolio->avg_price) * $userPortfolio->quantity;
                        @endphp
                        <p class="{{ $profit >= 0 ? 'text-green-400' : 'text-red-400' }}">
                            {{ $profit >= 0 ? '+' : '' }}${{ number_format(abs($profit), 2) }}
                        </p>
                    </div>
                </div>
            </div>
            @endif
            @endif
            @endauth
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-900 rounded-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Buy {{ $stock->symbol }}</h3>
                    <form action="{{ route('market.buy', $stock) }}" method="POST" id="buy-form">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Quantity</label>
                            <input type="number" name="quantity" id="buy-quantity-input" step="0.0001" min="0.0001" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Current Price</label>
                            <div class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white" id="current-price" data-price="{{ $currentPrice ?? 0 }}">${{ number_format($currentPrice ?? 0, 2) }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Total Cost</label>
                            <div class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white" id="buy-total-cost">$0.00</div>
                        </div>
                        <button type="submit" class="w-full bg-primary hover:bg-blue-500 py-3 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-shopping-cart mr-2"></i>Buy Now
                        </button>
                    </form>
                </div>

                @auth
                @if(!Auth::user()->isAdmin())
                <div class="bg-gray-900 rounded-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Sell {{ $stock->symbol }}</h3>
                    <form action="{{ route('market.sell', $stock) }}" method="POST" id="sell-form">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Quantity</label>
                            <input type="number" name="quantity" id="sell-quantity-input" step="0.0001" min="0.0001" max="{{ $userPortfolio ? $userPortfolio->quantity : 0 }}" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white" required {{ !($userPortfolio && $userPortfolio->quantity > 0) ? 'disabled' : '' }}>

                            @if($userPortfolio && $userPortfolio->quantity > 0)
                            <p class="text-sm text-gray-400 mt-1">Available: **{{ $userPortfolio->quantity }}** shares</p>
                            @else
                            <p class="text-sm text-red-400 mt-1">No shares available to sell</p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Current Price</label>
                            <div class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white">${{ number_format($currentPrice ?? 0, 2) }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Total Value</label>
                            <div class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white" id="sell-total-value">$0.00</div>
                        </div>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 py-3 rounded-lg font-semibold transition-colors" {{ !($userPortfolio && $userPortfolio->quantity > 0) ? 'disabled' : '' }}>
                            <i class="fas fa-arrow-up mr-2"></i>Sell Now
                        </button>
                    </form>
                </div>
                @endif
                @endauth
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById("stock-chart");
        if (!canvas) {
            console.error("Canvas dengan id 'stock-chart' tidak ditemukan!");
            return;
        }
        const ctx = canvas.getContext("2d");

        // Simpan instance chart di scope luar agar bisa di-destroy
        let stockChartInstance = null;

        // --- Elemen untuk perhitungan Total Cost/Value ---
        const buyQuantityInput = document.getElementById('buy-quantity-input');
        const sellQuantityInput = document.getElementById('sell-quantity-input');
        const currentPriceElement = document.getElementById('current-price');
        const currentPrice = parseFloat(currentPriceElement.getAttribute('data-price'));

        function calculateBuyTotal() {
            const quantity = parseFloat(buyQuantityInput.value) || 0;
            const totalCostElement = document.getElementById('buy-total-cost');
            if (quantity > 0 && !isNaN(currentPrice)) {
                const totalCost = quantity * currentPrice;
                totalCostElement.textContent = '$' + totalCost.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            } else {
                totalCostElement.textContent = '$0.00';
            }
        }

        function calculateSellTotal() {
            const quantity = parseFloat(sellQuantityInput.value) || 0;
            const totalValueElement = document.getElementById('sell-total-value');
            if (quantity > 0 && !isNaN(currentPrice)) {
                const totalValue = quantity * currentPrice;
                totalValueElement.textContent = '$' + totalValue.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            } else {
                totalValueElement.textContent = '$0.00';
            }
        }

        if (buyQuantityInput) {
            buyQuantityInput.addEventListener('input', calculateBuyTotal);
            calculateBuyTotal();
        }

        if (sellQuantityInput) {
            sellQuantityInput.addEventListener('input', calculateSellTotal);
            calculateSellTotal();
        }
        // --- Akhir Elemen perhitungan ---

        // Fetch data dan render chart
        function fetchAndRenderChart() {
            const chartResolution = '1m'; // Ambil data per 1 menit

            fetch(`/api/stock/{{ $stock->symbol }}/chart?resolution=${chartResolution}`)
                .then(res => res.json())
                .then(data => {

                    let absolutePrices = data.c;

                    // Validasi sederhana: Jika data kosong atau error, buat array kosong agar tidak crash
                    if (!absolutePrices || !Array.isArray(absolutePrices)) {
                        console.warn('Data harga tidak valid atau kosong');
                        absolutePrices = [];
                    }

                    const labels = data.t.map(t => {
                        const date = new Date(t * 1000);
                        return date.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false, // Gunakan format 24 jam (misal 22:30) biar tidak bingung AM/PM
                            timeZoneName: 'short' // Akan memunculkan "WIB"
                        });
                    });

                    // 1. Hancurkan instance chart yang lama jika ada
                    if (stockChartInstance) {
                        stockChartInstance.destroy();
                    }

                    // 2. Buat instance chart baru
                    stockChartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                label: '{{ $stock->symbol }} Price',
                                data: absolutePrices,
                                borderColor: '#0ea5e9',
                                backgroundColor: 'rgba(14,165,233,0.2)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    reverse: true,
                                    ticks: {
                                        color: '#ccc'
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.1)'
                                    }
                                },
                                y: {
                                    ticks: {
                                        color: '#ccc',
                                        callback: function(value, index, ticks) {
                                            return '$' + value.toFixed(2);
                                        }
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.1)'
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(err => console.error(err));
        }

        // 3. Panggil fungsi untuk pertama kali
        fetchAndRenderChart();

        // 4. Set interval untuk Polling (memanggil ulang setiap 5 detik)
        //setInterval(fetchAndRenderChart, 5000);
    });
</script>
@endpush
@extends('layouts.app')

@section('content')
@if(auth()->user()->isAdmin())
<div class="max-w-7xl mx-auto py-16 px-4">
    <div class="bg-gray-800 rounded-xl p-8 text-center">
        <i class="fas fa-lock text-6xl text-gray-500 mb-4"></i>
        <h2 class="text-3xl font-bold mb-4">Akses Ditolak</h2>
        <p class="text-xl text-gray-400 mb-6">Pengguna Admin tidak dapat mengakses tampilan pasar.</p>
        <a href="{{ route('admin.dashboard') }}" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
            Pergi ke Dashboard Admin
        </a>
    </div>
</div>
@else
<section class="py-16 px-4">
    {{-- Inisialisasi Alpine.js dengan variabel searchQuery --}}
    <div class="max-w-7xl mx-auto" x-data="{ searchQuery: '' }">
        <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
            <h2 class="text-3xl font-bold"><i class="fas fa-exchange-alt mr-3"></i>Market</h2>

            {{-- Kotak Pencarian --}}
            <input
                type="text"
                x-model.debounce.300ms="searchQuery"
                id="searchInput"
                placeholder="Cari saham"
                class="bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 w-64" />
        </div>

        {{-- Container untuk menampilkan hasil pencarian dinamis (termasuk yang non-visible) --}}
        <div id="searchResults" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" x-show="searchQuery.length > 0">
        </div>

        <script>
            document.getElementById('searchInput').addEventListener('input', async function() {
                let q = this.value.trim();
                const searchResultsEl = document.getElementById('searchResults');

                if (q.length < 1) {
                    searchResultsEl.innerHTML = "";
                    return;
                }

                // Tampilkan pesan loading saat mencari
                searchResultsEl.innerHTML = '<div class="col-span-3 text-center py-8 text-gray-400"><i class="fas fa-spinner fa-spin mr-2"></i>Mencari saham...</div>';

                try {
                    // Panggil rute search yang mencari di database lokal (termasuk non-visible)
                    let res = await fetch(`/market/search?q=` + encodeURIComponent(q));
                    let data = await res.json();

                    let html = "";

                    if (data.length === 0) {
                        html = '<div class="col-span-3 text-center py-8 text-gray-400">Tidak ada saham ditemukan di database lokal.</div>';
                    } else {
                        data.forEach(stock => {
                            // MENGGUNAKAN DATA HARGA DAN PERSENTASE DARI CONTROLLER
                            const currentPrice = stock.current_price || 0;
                            const percentChangeValue = stock.percent_change || 0;
                            const isPositive = percentChangeValue >= 0;

                            const price = '$' + currentPrice.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                            const percentChange = (isPositive ? '+' : '') + percentChangeValue.toFixed(2) + '%';
                            const percentClass = isPositive ? 'text-green-400' : 'text-red-400';

                            // Jika harga 0, tampilkan $0.00 dan N/A
                            const priceDisplay = currentPrice > 0 ? price : '$0.00';
                            const percentDisplay = currentPrice > 0 ? percentChange : 'N/A';
                            const finalPercentClass = currentPrice > 0 ? percentClass : 'text-gray-400';


                            html += `
                                <div class="stock-card bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-primary transition-all duration-200 shadow-xl">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold">${stock.symbol}</h3>
                                            <p class="text-gray-400">${stock.name}</p>
                                        </div>
                                        <span class="font-semibold ${finalPercentClass}">
                                            ${percentDisplay}
                                        </span>
                                    </div>
                                    <div class="text-2xl font-bold mb-2">
                                        ${priceDisplay}
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-400">&nbsp;</span>
                                        <a href="/market/${stock.id}" class="bg-primary hover:bg-blue-500 px-4 py-2 rounded-lg text-sm transition-colors shadow">
                                            <i class="fas fa-shopping-cart mr-1"></i>Beli
                                        </a>
                                    </div>
                                </div>
                            `;
                        });
                    }

                    searchResultsEl.innerHTML = html;

                } catch (error) {
                    searchResultsEl.innerHTML = '<div class="col-span-3 text-center py-8 text-red-400">Error fetching search results.</div>';
                    console.error('Error searching stocks:', error);
                }
            });
        </script>

        {{-- Grid Saham VISIBLE default (Hanya tampil jika searchQuery kosong) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-show="searchQuery.length === 0">
            @foreach($stocks as $stock)

            <div class="stock-card bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-primary transition-all duration-200 shadow-xl">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-bold">{{ $stock->symbol }}</h3>
                        <p class="text-gray-400">{{ $stock->name }}</p>
                    </div>

                    {{-- Logika Perhitungan Persentase Nyata (tetap Blade) --}}
                    <span class="font-semibold">
                        @if(isset($stock->current_price) && isset($stock->previous_close_price) && $stock->previous_close_price > 0)
                        @php
                        $prev = $stock->previous_close_price;
                        $curr = $stock->current_price;

                        $change = $curr - $prev;
                        $percentChange = ($change / $prev) * 100;
                        $isPositive = $change >= 0;
                        @endphp
                        <span class="{{ $isPositive ? 'text-green-400' : 'text-red-400' }}">
                            {{ $isPositive ? '+' : '' }}{{ number_format($percentChange, 2) }}%
                        </span>
                        @else
                        <span class="text-gray-400">N/A</span>
                        @endif
                    </span>
                    {{-- End Logika Perhitungan Persentase Nyata --}}
                </div>
                <div class="text-2xl font-bold mb-2">
                    @if(isset($stock->current_price))
                    ${{ number_format($stock->current_price, 2) }}
                    @else
                    $0.00
                    @endif
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">
                        &nbsp;
                    </span>
                    <a href="{{ route('market.show', $stock) }}" class="bg-primary hover:bg-blue-500 px-4 py-2 rounded-lg text-sm transition-colors shadow">
                        <i class="fas fa-shopping-cart mr-1"></i>Beli
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pesan "Tidak Ada Hasil Ditemukan" untuk grid default --}}
        <div x-show="searchQuery.length === 0 && {{ count($stocks) }} === 0"
            class="text-center py-8 text-gray-400">
            <p>Tidak ada saham yang tersedia di pasar saat ini.</p>
        </div>

        {{-- Pesan "Tidak Ada Hasil Ditemukan" saat pencarian API gagal --}}
        <div x-show="searchQuery.length > 0 && document.getElementById('searchResults').innerHTML.includes('Tidak ada saham ditemukan di database lokal.')"
            class="text-center py-8 text-gray-400"
            x-text="'Tidak ada saham ditemukan untuk pencarian &quot;' + searchQuery + '&quot; di database lokal.'">
        </div>
    </div>
</section>
@endif
@endsection
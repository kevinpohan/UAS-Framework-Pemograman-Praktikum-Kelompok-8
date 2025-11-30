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
    <div class="max-w-7xl mx-auto"
        x-data="{
            searchQuery: '',
            stocks: {{ json_encode($stocks->map(function($s) {
                return [
                    'id' => $s->id,
                    'symbol' => strtolower($s->symbol),
                    'symbol_display' => $s->symbol,
                    'name' => strtolower($s->name),
                    'name_display' => $s->name,
                    'visible' => $s->is_visible,
                    'current_price' => $s->current_price,
                    'previous_close_price' => $s->previous_close_price
                ];
            })) }},
            filterStocks() {
                return this.stocks.filter(stock => {
                    if(this.searchQuery === '') return stock.visible;
                    let q = this.searchQuery.toLowerCase();
                    return stock.symbol.includes(q) || stock.name.includes(q);
                });
            }
        }">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold"><i class="fas fa-exchange-alt mr-3"></i>Market</h2>

            <input
                type="text"
                x-model="searchQuery"
                placeholder="Cari saham"
                class="bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 w-64" />
        </div>

        <!-- Grid Saham -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <template x-for="stock in filterStocks()" :key="stock.id">
                <div class="stock-card bg-gray-800 rounded-xl p-6 border border-gray-700">

                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold" x-text="stock.symbol_display"></h3>
                            <p class="text-gray-400" x-text="stock.name_display"></p>
                        </div>

                        <span class="font-semibold" x-html="(() => {
                if(stock.current_price && stock.previous_close_price && stock.previous_close_price > 0) {
                    let c = stock.current_price - stock.previous_close_price;
                    let p = (c / stock.previous_close_price) * 100;
                    return `<span class='${c >= 0 ? 'text-green-400' : 'text-red-400'}'>
                        ${c >= 0 ? '+' : ''}${p.toFixed(2)}%
                    </span>`;
                }
                return `<span class='text-gray-400'>N/A</span>`;
            })()">
                        </span>
                    </div>

                    <div class="text-2xl font-bold mb-2"
                        x-text="'$' + ((stock.current_price ?? 0) * 1).toFixed(2)">
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Volume:
                            <span x-text="Math.floor(Math.random()*90+10) + '.' + Math.floor(Math.random()*90+10) + 'M'"></span>
                        </span>

                        <a :href="'/market/' + stock.id"
                            class="bg-primary hover:bg-blue-500 px-4 py-2 rounded-lg text-sm transition-colors">
                            <i class="fas fa-shopping-cart mr-1"></i>Beli
                        </a>
                    </div>

                </div>
            </template>

        </div>

        <!-- Tidak ada hasil -->
        <div x-show="filterStocks().length === 0"
            class="text-center py-8 text-gray-400"
            x-text="'Tidak ada saham ditemukan untuk pencarian: ‘' + searchQuery + '’'">
        </div>

    </div>
</section>

@endif
@endsection
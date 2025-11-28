@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">

    {{-- 1. HERO SECTION: Call to Action Dinamis --}}
    <section class="text-center py-20 bg-gray-900 rounded-2xl shadow-2xl mb-12 border border-gray-800">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-4 bg-gradient-to-r from-primary to-green-400 bg-clip-text text-transparent">
            Perdagangan Saham Simulasi Terbaik
        </h1>
        <p class="text-xl text-gray-300 mb-8 max-w-4xl mx-auto">
            Mulai praktik trading saham AS secara virtual. Bangun portofolio, uji strategi, tanpa risiko modal nyata.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="bg-primary hover:bg-blue-500 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                <i class="fas fa-user-shield mr-2"></i>Dashboard Admin
            </a>
            @else
            <a href="{{ route('market.index') }}" class="bg-primary hover:bg-blue-500 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                <i class="fas fa-rocket mr-2"></i>Mulai Trading Sekarang
            </a>
            @endif
            @else
            <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-600 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                <i class="fas fa-user-plus mr-2"></i>Daftar Gratis
            </a>
            <a href="#features" class="border-2 border-primary hover:bg-primary px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                <i class="fas fa-lightbulb mr-2"></i>Pelajari Fitur
            </a>
            @endauth
        </div>
    </section>

    {{-- 2. MARKET MOVERS (Top Gainers/Losers Section) --}}
    <div class="mb-12">
        <h2 class="text-3xl font-bold mb-6 text-white"><i class="fas fa-chart-bar mr-2 text-primary"></i>Ringkasan Pasar Utama</h2>

        @if(isset($marketMovers['gainers']) && isset($marketMovers['losers']))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Top Gainers Card (3 Performer Terbaik) --}}
            <div class="bg-gray-900 rounded-xl p-6 shadow-xl border border-gray-800">
                <h3 class="text-xl font-bold mb-4 text-green-400"><i class="fas fa-angle-double-up mr-2"></i>Top Gainers (USD)</h3>
                <div class="space-y-3 max-h-60 overflow-y-auto">
                    {{-- Menggunakan gainers dari service (3 perubahan tertinggi, bisa positif atau negatif) --}}
                    @forelse(collect($marketMovers['gainers'])->take(3) as $mover)
                    <div class="flex justify-between items-center py-2 border-b border-gray-800 last:border-b-0 hover:bg-gray-800 rounded px-2">
                        <a href="{{ route('market.index') }}" class="font-bold hover:text-white transition-colors">{{ $mover['symbol'] }}</a>

                        {{-- Logika untuk menampilkan tanda + atau - dengan benar --}}
                        @php
                        $change = $mover['change_percent'];
                        $isPositive = $change >= 0;
                        $changeText = number_format(abs($change), 2);
                        $class = $isPositive ? 'text-green-400' : 'text-red-400';
                        $sign = $isPositive ? '+' : '-';
                        @endphp

                        <span class="{{ $class }} font-semibold">{{ $sign }}{{ $changeText }}%</span>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-500">Data Top Gainers tidak tersedia saat ini.</div>
                    @endforelse
                </div>
            </div>

            {{-- Top Losers Card (3 Performer Terburuk) --}}
            <div class="bg-gray-900 rounded-xl p-6 shadow-xl border border-gray-800">
                <h3 class="text-xl font-bold mb-4 text-red-400"><i class="fas fa-angle-double-down mr-2"></i>Top Losers (USD)</h3>
                <div class="space-y-3 max-h-60 overflow-y-auto">
                    {{-- Menggunakan losers dari service (3 perubahan terendah/paling negatif) dan batasi 3 item --}}
                    @forelse(array_slice($marketMovers['losers'], 0, 3) as $mover)
                    <div class="flex justify-between items-center py-2 border-b border-gray-800 last:border-b-0 hover:bg-gray-800 rounded px-2">
                        <a href="{{ route('market.index') }}" class="font-bold hover:text-white transition-colors">{{ $mover['symbol'] }}</a>

                        {{-- Menampilkan nilai negatif apa adanya --}}
                        <span class="text-red-400 font-semibold">{{ number_format($mover['change_percent'], 2) }}%</span>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-500">Data Top Losers tidak tersedia saat ini.</div>
                    @endforelse
                </div>
            </div>
        </div>
        @else
        <div class="bg-gray-900 rounded-xl p-6 text-center text-gray-400">
            <p><i class="fas fa-info-circle mr-2"></i>Tidak dapat memuat Top Movers. Data Finnhub biasanya hanya tersedia selama jam perdagangan utama.</p>
        </div>
        @endif
    </div>

    <hr class="border-gray-700 my-8">

    {{-- 3. FEATURED STOCKS (Daftar Saham Unggulan) --}}
    <div class="mt-12">
        <h2 class="text-3xl font-bold mb-6 text-white" id="featured"><i class="fas fa-list-alt mr-2 text-primary"></i>Saham Unggulan (Top 8)</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($stocks as $stock)
            <div class="bg-gray-900 rounded-xl p-5 border border-gray-800 hover:border-primary transition-colors stock-card transform hover:scale-[1.02]">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-xl font-bold">{{ $stock->symbol }}</h3>
                    <a href="{{ route('market.show', $stock) }}" class="text-primary hover:text-blue-400">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <p class="text-gray-400 mb-4 text-sm truncate">{{ $stock->name }}</p>

                <div class="text-2xl font-bold">
                    @if(isset($stock->current_price))
                    ${{ number_format($stock->current_price, 2) }}
                    @else
                    $0.00
                    @endif
                </div>

                {{-- Percentage Change Display --}}
                <div class="mt-1">
                    @if(isset($stock->current_price) && isset($stock->previous_close_price) && $stock->previous_close_price > 0)
                    @php
                    $prev = $stock->previous_close_price;
                    $curr = $stock->current_price;

                    $change = $curr - $prev;
                    $percentChange = ($change / $prev) * 100;
                    $isPositive = $change >= 0;
                    @endphp
                    <span class="{{ $isPositive ? 'text-green-400' : 'text-red-400' }} text-sm font-semibold">
                        {{ $isPositive ? '+' : '' }}{{ number_format($percentChange, 2) }}%
                    </span>
                    @else
                    <span class="text-gray-500 text-sm">N/A</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center py-10 text-gray-400">
                <i class="fas fa-box-open text-4xl mb-4"></i>
                <p>Belum ada saham yang ditambahkan ke database.</p>
            </div>
            @endforelse
        </div>

        <div class="mt-10 text-center">
            @auth
            @if(!auth()->user()->isAdmin())
            <a href="{{ route('market.index') }}" class="bg-primary hover:bg-blue-500 px-8 py-3 rounded-lg text-lg font-semibold transition-colors inline-flex items-center">
                <i class="fas fa-angle-double-right mr-2"></i>Lihat Semua Pasar
            </a>
            @endif
            @endauth
        </div>
    </div>

    <hr class="border-gray-700 my-12">

    {{-- 4. ADDITIONAL INFO / APP FEATURES --}}
    <section id="features" class="py-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-white"><i class="fas fa-shield-alt mr-2 text-primary"></i>Keuntungan TradeInk</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-gray-900 rounded-xl p-6 text-center border border-gray-800 shadow-lg">
                <i class="fas fa-money-bill-wave text-green-400 text-4xl mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Simulasi Bebas Risiko</h3>
                <p class="text-gray-400">Uji strategi trading Anda dengan dana virtual 100%, tanpa kehilangan uang sungguhan.</p>
            </div>
            <div class="bg-gray-900 rounded-xl p-6 text-center border border-gray-800 shadow-lg">
                <i class="fas fa-clock text-primary text-4xl mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Data Real-time (Near)</h3>
                <p class="text-gray-400">Dapatkan data harga saham AS yang akurat, terintegrasi API.</p>
            </div>
            <div class="bg-gray-900 rounded-xl p-6 text-center border border-gray-800 shadow-lg">
                <i class="fas fa-chart-pie text-red-400 text-4xl mb-4"></i>
                <h3 class="text-xl font-bold mb-2">Pelacakan Portofolio Detail</h3>
                <p class="text-gray-400">Lacak untung/rugi rata-rata, dan riwayat transaksi Anda secara komprehensif.</p>
            </div>
        </div>
    </section>
</div>
@endsection
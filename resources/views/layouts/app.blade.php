<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TradeInk') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
        }

        .stock-card {
            transition: all 0.3s ease;
        }

        .stock-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .portfolio-item {
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-900 text-white">
    <!-- Navigation -->
    <nav class="bg-secondary shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-chart-line text-primary text-2xl"></i>
                    <a href="{{ route('home') }}" class="text-xl font-bold">TradeInk</a>
                </div>

                <div class="hidden md:flex space-x-8">
                    @auth
                    @if(auth()->user()->isAdmin())
                    <!-- Admin Navigation -->
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-primary' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.users.index') }}" class="hover:text-primary transition-colors {{ request()->routeIs('admin.users.*') ? 'text-primary' : '' }}">Users</a>
                    <a href="{{ route('admin.stocks.index') }}" class="hover:text-primary transition-colors {{ request()->routeIs('admin.stocks.*') ? 'text-primary' : '' }}">Stocks</a>
                    <a href="{{ route('admin.topups.index') }}" class="hover:text-primary transition-colors {{ request()->routeIs('admin.topups.*') ? 'text-primary' : '' }}">Top-ups</a>
                    @else
                    <!-- User Navigation -->
                    <a href="{{ route('market.index') }}" class="hover:text-primary transition-colors {{ request()->routeIs('market.*') ? 'text-primary' : '' }}">Market</a>
                    <a href="{{ route('portfolio.index') }}" class="hover:text-primary transition-colors {{ request()->routeIs('portfolio.*') ? 'text-primary' : '' }}">Portfolio</a>
                    <a href="{{ route('transactions.index') }}" class="hover:text-primary transition-colors {{ request()->routeIs('transactions.*') ? 'text-primary' : '' }}">Transactions</a>
                    <a href="{{ route('forecast.index') }}"
                        class="hover:text-primary transition-colors {{ request()->routeIs('forecast.*') ? 'text-primary' : '' }}">
                        Forecasting
                    </a>

                    @endif
                    @endauth
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                    <div class="text-right">
                        <div class="text-sm">Balance: ${{ number_format(Auth::user()->balance, 2) }}</div>
                    </div>
                    <div class="relative">
                        <img src="https://placehold.co/40x40/0ea5e9/ffffff?text={{ substr(Auth::user()->name, 0, 1) }}" alt="User" class="w-10 h-10 rounded-full">
                    </div>
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="text-white hover:text-primary">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 z-50">
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">Admin Dashboard</a>
                            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">Users</a>
                            <a href="{{ route('admin.stocks.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.stocks.*') ? 'bg-gray-700' : '' }}">Stocks</a>
                            <a href="{{ route('admin.topups.index') }}" class="block px-4 py-2 hover:bg-gray-700 {{ request()->routeIs('admin.topups.*') ? 'bg-gray-700' : '' }}">Top-ups</a>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-700">Profile</a>
                            @else
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 hover:bg-gray-700">Profile</a>
                            <a href="{{ route('topup.create') }}" class="block px-4 py-2 hover:bg-gray-700">Top-up</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-700">Logout</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-white hover:text-primary">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary hover:bg-blue-500 px-4 py-2 rounded-lg transition-colors">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-green-600 text-white p-4 rounded-lg">
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="bg-red-600 text-white p-4 rounded-lg">
            {{ session('error') }}
        </div>
    </div>
    @endif

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-secondary py-12 px-4 mt-16">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-chart-line text-primary text-2xl"></i>
                        <span class="text-xl font-bold">TradeInk</span>
                    </div>
                    <p class="text-gray-400">Your ultimate stock market simulator for learning and practicing trading strategies.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Developers</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><b>I</b>man NurWahyu</li>
                        <li>Ayang <b>N</b>ova Anggraeni</li>
                        <li><b>K</b>evin Victorian Salomo Pohan</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Features</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Real-time Market Data</li>
                        <li>Portfolio Tracking</li>
                        <li>Transaction History</li>
                        <li>Admin Dashboard</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Documentation</li>
                        <li>API Reference</li>
                        <li>Community</li>
                        <li>Contact Us</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 TradeInk. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
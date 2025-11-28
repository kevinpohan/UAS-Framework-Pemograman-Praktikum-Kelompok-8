@extends('layouts.app')

@section('content')
<section class="py-16 px-4 bg-gray-800">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold mb-8"><i class="fas fa-crown mr-3"></i>Admin Dashboard</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-900 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-primary mb-2">{{ $totalUsers }}</div>
                <div class="text-gray-400">Total Users</div>
            </div>
            <div class="bg-gray-900 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-primary mb-2">{{ $totalTransactions }}</div>
                <div class="text-gray-400">Total Trades</div>
            </div>
            <div class="bg-gray-900 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-yellow-400 mb-2">{{ $pendingTopupsCount }}</div>
                <div class="text-gray-400">Pending Top-ups</div>
            </div>
            <div class="bg-gray-900 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-primary mb-2">${{ number_format($totalVolume, 2) }}</div>
                <div class="text-gray-400">Total Volume</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-gray-900 rounded-xl p-6">
                <h3 class="text-xl font-bold mb-4">Pending Top-ups</h3>
                <div class="space-y-4">
                    @forelse($pendingTopups as $topup)
                    <div class="flex justify-between items-center p-4 bg-gray-800 rounded-lg">
                        <div>
                            <div class="font-bold">{{ $topup->user->name }}</div>
                            <div class="text-sm text-gray-400">${{ number_format($topup->amount, 2) }}</div>
                        </div>
                        <div class="space-x-2">
                            <form action="{{ route('admin.topups.approve', $topup) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 px-3 py-1 rounded text-sm">Approve</button>
                            </form>
                            <form action="{{ route('admin.topups.reject', $topup) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-sm">Reject</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-400">
                        No pending top-ups
                    </div>
                    @endforelse
                </div>
                <div class="mt-4 text-center">

                    <a href="{{ route('admin.topups.index') }}" class="bg-white-600 hover:bg-white-700 px-3 py-1 rounded text-sm">
                        Lihat Semua
                    </a>

                </div>
            </div>

            <div class="bg-gray-900 rounded-xl p-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold mb-4">Recent Transactions</h3>
                    {{-- TOMBOL EXPORT --}}
                    <div class="flex gap-2">
                        <a href="{{ route('admin.dashboard.export.excel') }}" class="text-green-500 hover:text-green-400" title="Export to Excel">
                            <i class="fas fa-file-excel fa-lg"></i>
                        </a>
                        <a href="{{ route('admin.dashboard.export.pdf') }}" class="text-red-500 hover:text-red-400" title="Export to PDF">
                            <i class="fas fa-file-pdf fa-lg"></i>
                        </a>
                    </div>
                </div>
                <div class="space-y-3">
                    @forelse($recentTransactions as $transaction)
                    <div class="flex justify-between items-center p-3 bg-gray-800 rounded">
                        <div class="flex items-center space-x-3">
                            <img src="https://placehold.co/30x30/0ea5e9/ffffff?text={{ substr($transaction->user->name, 0, 1) }}" alt="User" class="w-8 h-8 rounded-full">
                            <div>
                                <div class="font-bold">{{ $transaction->user->name }}</div>
                                <div class="text-sm text-gray-400">
                                    {{ ucfirst($transaction->type) }} {{ $transaction->stock ? $transaction->stock->symbol : '' }} {{ $transaction->qty ?? '' }}
                                </div>
                            </div>
                        </div>
                        <div class="{{ $transaction->type === 'buy' ? 'text-green-400' : ($transaction->type === 'sell' ? 'text-red-400' : 'text-blue-400') }}">
                            ${{ number_format($transaction->total, 2) }}
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-400">
                        No recent transactions
                    </div>
                    @endforelse
                </div>

                {{-- Menampilkan link paginasi untuk Recent Transactions --}}
                @if($recentTransactions->hasPages())
                <div class="mt-4">
                    {{ $recentTransactions->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
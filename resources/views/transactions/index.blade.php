@extends('layouts.app')

@section('content')
@if(auth()->user()->isAdmin())
<div class="max-w-7xl mx-auto py-16 px-4">
    <div class="bg-gray-800 rounded-xl p-8 text-center">
        <i class="fas fa-lock text-6xl text-gray-500 mb-4"></i>
        <h2 class="text-3xl font-bold mb-4">Access Denied</h2>
        <p class="text-xl text-gray-400 mb-6">Admin users cannot access the transactions view.</p>
        <a href="{{ route('admin.dashboard') }}" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
            Go to Admin Dashboard
        </a>
    </div>
</div>
@else
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold mb-8"><i class="fas fa-history mr-3"></i>Transaction History</h2>
            <div class="flex gap-2">
                <a href="{{ route('transactions.export.excel') }}" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg font-semibold transition-colors text-white text-sm">
                    <i class="fas fa-file-excel mr-2"></i>Export Excel
                </a>
                <a href="{{ route('transactions.export.pdf') }}" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-semibold transition-colors text-white text-sm">
                    <i class="fas fa-file-pdf mr-2"></i>Export PDF
                </a>
            </div>
        </div>
        <div class="bg-gray-800 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="text-left py-4 px-6">Date</th>
                            <th class="text-left py-4 px-6">Symbol</th>
                            <th class="text-left py-4 px-6">Type</th>
                            <th class="text-left py-4 px-6">Quantity</th>
                            <th class="text-left py-4 px-6">Price</th>
                            <th class="text-left py-4 px-6">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                        <tr class="border-t border-gray-700 hover:bg-gray-750">
                            <td class="py-4 px-6">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                            <td class="py-4 px-6 font-bold">{{ $transaction->stock ? $transaction->stock->symbol : '' }}</td>
                            <td class="py-4 px-6 
                                            {{ $transaction->type === 'buy' ? 'text-green-400' : 
                                               ($transaction->type === 'sell' ? 'text-red-400' : 'text-blue-400') }}">
                                {{ ucfirst($transaction->type) }}
                            </td>
                            <td class="py-4 px-6">{{ $transaction->qty ?? '' }}</td>
                            <td class="py-4 px-6">${{ number_format($transaction->price ?? $transaction->total,2 ) }}</td>
                            <td class="py-4 px-6">${{ number_format($transaction->total, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                <p>No transactions found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
            <div class="px-6 py-4 bg-gray-700">
                {{ $transactions->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
@endif
@endsection
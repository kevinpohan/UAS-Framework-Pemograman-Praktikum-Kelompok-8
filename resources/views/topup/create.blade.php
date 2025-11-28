@extends('layouts.app')

@section('content')
@if(auth()->user()->isAdmin())
<div class="max-w-7xl mx-auto py-16 px-4">
    <div class="bg-gray-800 rounded-xl p-8 text-center">
        <i class="fas fa-lock text-6xl text-gray-500 mb-4"></i>
        <h2 class="text-3xl font-bold mb-4">Access Denied</h2>
        <p class="text-xl text-gray-400 mb-6">Admin users cannot access the top-up form.</p>
        <a href="{{ route('admin.dashboard') }}" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
            Go to Admin Dashboard
        </a>
    </div>
</div>
@else
<section class="py-16 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-gray-800 rounded-xl p-8">
            <h2 class="text-3xl font-bold mb-8 text-center">Top-up Account</h2>

            <form method="POST" action="{{ route('topup.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Amount (USD)</label>
                    <input type="number" name="amount" step="0.01" min="10" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                    <p class="text-sm text-gray-400 mt-1">Minimum top-up amount is $10.00</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Proof of Payment</label>
                    <input type="file" name="proof" accept="image/*" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3">
                    <p class="text-sm text-gray-400 mt-1">Upload a screenshot or receipt of your payment</p>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-blue-500 py-3 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Top-up Request
                </button>
            </form>

            <div class="mt-8 p-4 bg-gray-700 rounded-lg">
                <h3 class="font-bold mb-2">Top-up Process:</h3>
                <ol class="list-decimal list-inside space-y-1 text-sm text-gray-300">
                    <li>Enter the amount you want to top-up</li>
                    <li>Upload proof of payment (screenshot, receipt, etc.)</li>
                    <li>Submit the request</li>
                    <li>Wait for admin approval</li>
                    <li>Balance will be added after approval</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endif
@endsection
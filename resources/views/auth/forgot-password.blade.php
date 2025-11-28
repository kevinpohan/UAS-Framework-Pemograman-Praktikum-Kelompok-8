@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-md mx-auto">
        <div class="bg-gray-800 rounded-xl p-8 shadow-lg">
            <div class="text-center mb-8">
                <i class="fas fa-key text-primary text-4xl mb-4"></i>
                <h2 class="text-3xl font-bold">Reset Password</h2>
                <p class="text-gray-400 mt-2">Enter your email to receive reset link</p>
            </div>

            @if (session('status'))
            <div class="bg-green-600 text-white p-4 rounded-lg mb-6">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-blue-500 py-3 rounded-lg font-semibold transition-colors">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-400 text-sm">
                    <a href="{{ route('login') }}" class="text-primary hover:underline">
                        ← Back to Login
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
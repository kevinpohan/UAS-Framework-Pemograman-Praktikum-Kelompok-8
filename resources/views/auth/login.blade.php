@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-md mx-auto">
        <div class="bg-gray-800 rounded-xl p-8 shadow-lg">
            <div class="text-center mb-8">
                <i class="fas fa-chart-line text-primary text-4xl mb-4"></i>
                <h2 class="text-3xl font-bold">Welcome Back</h2>
                <p class="text-gray-400 mt-2">Sign in to your TradeInk account</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium mb-2">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 @error('password') border-red-500 @enderror">
                    @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                        class="text-primary rounded">
                    <label for="remember" class="ml-2 text-sm">Remember me</label>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-blue-500 py-3 rounded-lg font-semibold transition-colors">
                    Sign In
                </button>
            </form>

            <!-- OR divider -->
            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-600">
                <span class="px-4 text-gray-400 text-sm">OR</span>
                <hr class="flex-grow border-gray-600">
            </div>

            <a href="{{ route('google.login') }}"
                class="flex items-center justify-center w-full bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg px-4 py-3 transition-colors shadow-md">
                <i class="fab fa-google w-5 h-5 mr-3"></i>

                Sign in with Google
            </a>



            <div class="mt-6 text-center">
                <p class="text-gray-400 text-sm">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-primary hover:underline">Sign up</a>
                </p>
                @if (Route::has('password.request'))
                <p class="text-gray-400 text-sm mt-2">
                    <a class="text-primary hover:underline" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                </p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
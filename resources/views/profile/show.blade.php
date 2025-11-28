@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-gray-800 rounded-xl p-8">
            <h2 class="text-3xl font-bold mb-8">Profile Settings</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1">
                    <div class="text-center">
                        <img src="https://placehold.co/120x120/0ea5e9/ffffff?text={{ substr($user->name, 0, 1) }}" alt="Profile" class="w-32 h-32 rounded-full mx-auto mb-4">
                        <h3 class="text-xl font-bold">{{ $user->name }}</h3>
                        <p class="text-gray-400">{{ $user->email }}</p>
                        <p class="text-sm mt-2">Balance: ${{ number_format($user->balance, 2) }}</p>
                        <p class="text-sm mt-1">Role: {{ ucfirst($user->role) }}</p>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                        </div>

                        <button type="submit" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-save mr-2"></i>Update Profile
                        </button>
                    </form>

                    <div class="mt-8">
                        <h3 class="text-xl font-bold mb-4">Change Password</h3>
                        <form method="POST" action="{{ route('profile.password') }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Current Password</label>
                                <input type="password" name="current_password" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">New Password</label>
                                <input type="password" name="new_password" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium mb-2">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                            </div>

                            <button type="submit" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                                <i class="fas fa-key mr-2"></i>Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
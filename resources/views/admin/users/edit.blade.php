@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-gray-800 rounded-xl p-8">
            <h2 class="text-3xl font-bold mb-8">Edit User</h2>

            <form method="POST" action="{{ route('admin.users.update', $user) }}">
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

                <div class="flex space-x-4">
                    <button type="submit" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-save mr-2"></i>Update User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-600 hover:bg-gray-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                        Cancel
                    </a>
                </div>
            </form>

            <!-- <div class="mt-8">
                <h3 class="text-xl font-bold mb-4">Reset Password</h3>
                <form method="POST" action="{{ route('admin.users.reset-password', $user) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">New Password</label>
                        <input type="password" name="new_password" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                    </div>

                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-key mr-2"></i>Reset Password
                    </button>
                </form>
            </div> -->
        </div>
    </div>
</section>
@endsection
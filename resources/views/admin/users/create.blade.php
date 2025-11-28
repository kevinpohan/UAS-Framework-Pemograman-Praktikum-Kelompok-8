@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-gray-800 rounded-xl p-8">
            <h2 class="text-3xl font-bold mb-8">Add New Admin</h2>

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Password</label>
                    <input type="password" name="password" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-save mr-2"></i>Create Admin
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-600 hover:bg-gray-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
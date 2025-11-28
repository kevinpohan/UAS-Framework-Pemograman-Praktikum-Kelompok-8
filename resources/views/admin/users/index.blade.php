@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Manage Users</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                <i class="fas fa-plus mr-2"></i>Add Admin
            </a>
        </div>

        <div class="bg-gray-800 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    @php
                    $nextDirection = $direction === 'asc' ? 'desc' : 'asc';
                    $sortIcon = fn($col) => $sort === $col ? ($direction === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort text-gray-600"></i>';
                    @endphp

                    <thead class="bg-gray-700">
                        <tr>
                            <th class="text-left py-4 px-6 cursor-pointer hover:bg-gray-600 transition">
                                <a href="{{ route('admin.users.index', ['sort' => 'name', 'direction' => $nextDirection]) }}" class="flex items-center gap-2 w-full h-full">
                                    Name {!! $sortIcon('name') !!}
                                </a>
                            </th>
                            <th class="text-left py-4 px-6 cursor-pointer hover:bg-gray-600 transition">
                                <a href="{{ route('admin.users.index', ['sort' => 'email', 'direction' => $nextDirection]) }}" class="flex items-center gap-2 w-full h-full">
                                    Email {!! $sortIcon('email') !!}
                                </a>
                            </th>
                            <th class="text-left py-4 px-6 cursor-pointer hover:bg-gray-600 transition">
                                <a href="{{ route('admin.users.index', ['sort' => 'role', 'direction' => $nextDirection]) }}" class="flex items-center gap-2 w-full h-full">
                                    Role {!! $sortIcon('role') !!}
                                </a>
                            </th>
                            <th class="text-left py-4 px-6 cursor-pointer hover:bg-gray-600 transition">
                                <a href="{{ route('admin.users.index', ['sort' => 'balance', 'direction' => $nextDirection]) }}" class="flex items-center gap-2 w-full h-full">
                                    Balance {!! $sortIcon('balance') !!}
                                </a>
                            </th>
                            <th class="text-left py-4 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-t border-gray-700 hover:bg-gray-750">
                            <td class="py-4 px-6 font-bold">{{ $user->name }}</td>
                            <td class="py-4 px-6">{{ $user->email }}</td>
                            <td class="py-4 px-6">
                                <span class="{{ $user->role === 'admin' ? 'bg-red-600' : 'bg-blue-600' }} text-white px-2 py-1 rounded text-sm">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">${{ number_format($user->balance, 2) }}</td>
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-400 hover:text-blue-300 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                {{-- Mengganti form lama dengan tombol modal trigger --}}
                                <button type="button"
                                    class="text-red-400 hover:text-red-300"
                                    x-data="{}"
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-{{ $user->id }}')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>

                                {{-- Modal untuk konfirmasi penghapusan (menggunakan komponen yang telah dimodifikasi sebelumnya) --}}
                                <x-modal name="confirm-user-deletion-{{ $user->id }}" :show="false" maxWidth="md">
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="p-6 bg-gray-900 rounded-lg">
                                        @csrf
                                        @method('DELETE')

                                        <h2 class="text-xl font-bold text-white mb-2">
                                            Confirm Deletion
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-400">
                                            Are you sure you want to delete user <b>{{ $user->name }}</b> ({{ $user->email }})?
                                        </p>

                                        @if($user->id === auth()->id())
                                        <p class="mt-4 text-sm text-red-500">
                                            You cannot delete your own admin account.
                                        </p>
                                        @endif

                                        <div class="mt-6 flex justify-end gap-3">
                                            <button type="button" x-on:click="$dispatch('close')" class="bg-gray-600 hover:bg-gray-500 px-4 py-2 rounded-lg font-semibold transition-colors text-white">
                                                Cancel
                                            </button>

                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-semibold transition-colors text-white disabled:opacity-50 disabled:cursor-not-allowed"
                                                @if($user->id === auth()->id()) disabled @endif
                                                >
                                                Delete Account
                                            </button>
                                        </div>
                                    </form>
                                </x-modal>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
            <div class="px-6 py-4 bg-gray-700">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</section>
@endsection
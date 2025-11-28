@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Manage Stocks</h2>
            <div class="flex gap-2">
                {{-- Tombol Export --}}
                <a href="{{ route('admin.stocks.export.excel') }}" class="bg-green-600 hover:bg-green-700 px-4 py-3 rounded-lg font-semibold transition-colors text-white">
                    <i class="fas fa-file-excel mr-2"></i>Excel
                </a>
                <a href="{{ route('admin.stocks.export.pdf') }}" class="bg-red-600 hover:bg-red-700 px-4 py-3 rounded-lg font-semibold transition-colors text-white">
                    <i class="fas fa-file-pdf mr-2"></i>PDF
                </a>

                {{-- Tombol Add Stock yang sudah ada --}}
                <a href="{{ route('admin.stocks.create') }}" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-plus mr-2"></i>Add Stock
                </a>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    @php
                    $nextDirection = isset($direction) && $direction === 'asc' ? 'desc' : 'asc';
                    $currentSort = isset($sort) ? $sort : '';
                    $sortIcon = fn($col) => $currentSort === $col ? ($direction === 'asc' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort-down"></i>') : '<i class="fas fa-sort text-gray-600"></i>';
                    @endphp

                    <thead class="bg-gray-700">
                        <tr>
                            <th class="text-left py-4 px-6">
                                <a href="{{ route('admin.stocks.index', ['sort' => 'symbol', 'direction' => $nextDirection]) }}" class="flex items-center gap-2">
                                    Symbol {!! $sortIcon('symbol') !!}
                                </a>
                            </th>
                            <th class="text-left py-4 px-6">
                                <a href="{{ route('admin.stocks.index', ['sort' => 'name', 'direction' => $nextDirection]) }}" class="flex items-center gap-2">
                                    Name {!! $sortIcon('name') !!}
                                </a>
                            </th>
                            <th class="text-left py-4 px-6">Currency</th>
                            <th class="text-left py-4 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stocks as $stock)
                        <tr class="border-t border-gray-700 hover:bg-gray-750">
                            <td class="py-4 px-6 font-bold">{{ $stock->symbol }}</td>
                            <td class="py-4 px-6">{{ $stock->name }}</td>
                            <td class="py-4 px-6">{{ $stock->currency }}</td>
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.stocks.edit', $stock) }}" class="text-blue-400 hover:text-blue-300 mr-3">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                {{-- Mengganti tombol submit lama yang memicu alert onclick menjadi tombol trigger modal --}}
                                <button type="button"
                                    class="text-red-400 hover:text-red-300"
                                    x-data="{}"
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-stock-deletion-{{ $stock->id }}')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($stocks->hasPages())
            <div class="px-6 py-4 bg-gray-700">
                {{ $stocks->links() }}
            </div>
            @endif
        </div>
    </div>
</section>

{{-- DEFINISI MODAL UNTUK KONFIRMASI PENGHAPUSAN (Ditempatkan di luar loop tabel) --}}
@foreach($stocks as $stock)
<x-modal name="confirm-stock-deletion-{{ $stock->id }}" :show="false" maxWidth="md">
    <form method="POST" action="{{ route('admin.stocks.destroy', $stock) }}" class="p-6 bg-gray-900 rounded-lg">
        @csrf
        @method('DELETE')

        <h2 class="text-xl font-bold text-red-500 mb-2">
            Confirm Stock Deletion
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            Are you sure you want to delete the stock <b>{{ $stock->symbol }}</b> ({{ $stock->name }})?
            This action cannot be undone.
        </p>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" x-on:click="$dispatch('close')" class="bg-gray-600 hover:bg-gray-500 px-4 py-2 rounded-lg font-semibold transition-colors text-white">
                Cancel
            </button>

            <button type="submit"
                class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-semibold transition-colors text-white">
                Delete Stock
            </button>
        </div>
    </form>
</x-modal>
@endforeach

@endsection
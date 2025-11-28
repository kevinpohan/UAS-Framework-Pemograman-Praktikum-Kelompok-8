@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-gray-800 rounded-xl p-8">
            <h2 class="text-3xl font-bold mb-8">Edit Stock</h2>

            <form method="POST" action="{{ route('admin.stocks.update', $stock) }}" id="edit-stock-form">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Symbol</label>
                    <input type="text" name="symbol" id="symbol-input" value="{{ old('symbol', $stock->symbol) }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                    <p class="text-sm text-gray-400 mt-1">e.g., AAPL, MSFT, GOOGL</p>
                    <div id="loading-message" class="text-sm text-yellow-400 mt-1 hidden">Searching...</div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name-input" value="{{ old('name', $stock->name) }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                    <p class="text-sm text-gray-400 mt-1">e.g., Apple Inc., Microsoft Corporation</p>
                </div>

                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_visible"
                            {{ $stock->is_visible ? 'checked' : '' }} class="mr-2">
                        <span>Tampilkan di Market?</span>
                    </label>
                </div>

                <div class="flex space-x-4 mt-6">
                    <button type="submit" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Stock
                    </button>
                    <a href="{{ route('admin.stocks.index') }}" class="bg-gray-600 hover:bg-gray-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const symbolInput = document.getElementById('symbol-input');
        const nameInput = document.getElementById('name-input');
        const loadingMessage = document.getElementById('loading-message');

        let searchTimeout;

        symbolInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim().toUpperCase();

            if (query.length < 2) {
                loadingMessage.classList.add('hidden');
                return;
            }

            // Atur timeout untuk menghindari spam API call
            searchTimeout = setTimeout(() => {
                loadingMessage.classList.remove('hidden');

                // Memanggil API search yang sudah ada
                fetch(`/admin/stocks/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        loadingMessage.classList.add('hidden');

                        // Mencari hasil yang simbolnya persis sama dengan yang diinput
                        const exactMatch = data.find(item => item.symbol === query);

                        if (exactMatch && exactMatch.name) {
                            nameInput.value = exactMatch.name;
                        } else {
                            // Opsional: berikan feedback jika tidak ditemukan
                            // nameInput.value = 'Name not found via API';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching stock name:', error);
                        loadingMessage.classList.add('hidden');
                    });
            }, 500); // Tunggu 500ms setelah mengetik
        });
    });
</script>
@endsection
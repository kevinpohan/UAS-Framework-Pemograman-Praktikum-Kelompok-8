@extends('layouts.app')

@section('content')
<section class="py-16 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="bg-gray-800 rounded-xl p-8">
            <h2 class="text-3xl font-bold mb-8">Add New Stock</h2>

            <form method="POST" action="{{ route('admin.stocks.store') }}" id="stock-form">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Search Stock</label>
                    <input type="text" id="search-input" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" placeholder="Type to search for stocks...">
                    <div id="search-results" class="mt-2 bg-gray-700 rounded-lg max-h-60 overflow-y-auto hidden">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Symbol</label>
                    <input type="text" name="symbol" id="symbol" value="{{ old('symbol') }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                    <p class="text-sm text-gray-400 mt-1">e.g., AAPL, MSFT, GOOGL</p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3" required>
                    <p class="text-sm text-gray-400 mt-1">e.g., Apple Inc., Microsoft Corporation</p>
                </div>

                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_visible" checked class="mr-2">
                        <span>Tampilkan di Market?</span>
                    </label>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-primary hover:bg-blue-500 px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-save mr-2"></i>Create Stock
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
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');
        const symbolInput = document.getElementById('symbol');
        const nameInput = document.getElementById('name');
        const form = document.getElementById('stock-form');

        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`/admin/stocks/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.data) {
                            displaySearchResults(data.data);
                        } else if (Array.isArray(data)) {
                            displaySearchResults(data);
                        } else {
                            searchResults.classList.add('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error searching stocks:', error);
                        searchResults.classList.add('hidden');
                    });
            }, 300);
        });

        function displaySearchResults(results) {
            if (!results || results.length === 0) {
                searchResults.innerHTML = '<div class="p-4 text-center text-gray-400">No results found</div>';
                searchResults.classList.remove('hidden');
                return;
            }

            let html = '';
            results.forEach(stock => {
                html += `
                        <div class="p-3 hover:bg-gray-600 cursor-pointer border-b border-gray-600 search-result-item" 
                            data-symbol="${stock.symbol}" 
                            data-name="${stock.name}"
                            <div class="font-bold">${stock.symbol}</div>
                            <div class="text-sm text-gray-400 pl-2">${stock.name}</div>
                        </div>
                    `;
            });

            searchResults.innerHTML = html;
            searchResults.classList.remove('hidden');

            // Add event listeners to search result items
            document.querySelectorAll('.search-result-item').forEach(item => {
                item.addEventListener('click', function() {
                    const symbol = this.getAttribute('data-symbol');
                    const name = this.getAttribute('data-name');

                    symbolInput.value = symbol;
                    nameInput.value = name;

                    searchResults.classList.add('hidden');
                    searchInput.value = symbol;
                });
            });
        }

        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchResults.contains(e.target) && e.target !== searchInput) {
                searchResults.classList.add('hidden');
            }
        });
    });
</script>
@endsection
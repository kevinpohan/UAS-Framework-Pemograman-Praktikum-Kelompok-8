<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Services\StockPriceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Exports\StocksExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class StockController extends Controller
{
    protected $priceService;

    public function __construct(StockPriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    public function index(Request $request)
    {
        $sort = $request->input('sort', 'symbol');
        $direction = $request->input('direction', 'asc');

        $allowedSorts = ['symbol', 'name', 'currency'];
        if (!in_array($sort, $allowedSorts)) $sort = 'symbol';
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        $stocks = Stock::orderBy($sort, $direction)->paginate(15)
            ->appends(['sort' => $sort, 'direction' => $direction]);

        return view('admin.stocks.index', compact('stocks', 'sort', 'direction'));
    }

    public function create()
    {
        return view('admin.stocks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'symbol' => 'required|string|unique:stocks,symbol',
            'name' => 'required|string',
        ]);

        Stock::create([
            'symbol' => $request->symbol,
            'name' => $request->name,
            'currency' => 'USD',
            'is_visible' => $request->has('is_visible'),
        ]);

        return redirect()->route('admin.stocks.index')->with('success', 'Stock created successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (!$query) {
            return response()->json([]);
        }

        // Gunakan StockPriceService untuk mencari, yang akan secara otomatis
        $data = $this->priceService->searchStocks($query);

        if ($data && isset($data['result']) && is_array($data['result'])) {
            // Mapping hasil dari Finnhub API: 'symbol' dan 'description'
            $results = collect($data['result'])->map(function ($item) {
                return [
                    'symbol' => $item['symbol'] ?? '',
                    'name' => $item['description'] ?? '',
                ];
            })->filter(function ($item) {
                return !empty($item['symbol']);
            })->values();

            return response()->json($results);
        }

        return response()->json([]);
    }

    public function edit(Stock $stock)
    {
        return view('admin.stocks.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'symbol' => 'required|string|unique:stocks,symbol,' . $stock->id,
            'name' => 'required|string',
        ]);

        $stock->update([
            'symbol' => $request->symbol,
            'name' => $request->name,
            'is_visible' => $request->has('is_visible'),
        ]);

        return redirect()->route('admin.stocks.index')->with('success', 'Stock updated successfully.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        return redirect()->route('admin.stocks.index')->with('success', 'Stock deleted successfully.');
    }

    public function showChart($symbol)
    {
        $data = $this->priceService->getHistoricalPrices($symbol);

        if (!$data || !isset($data['t'])) {
            return back()->with('error', 'Data harga tidak tersedia untuk simbol ini.');
        }

        // Format data untuk chart
        $labels = array_map(fn($t) => date('d/m/Y', $t), $data['t']);
        $prices = $data['c'];

        if (!empty($labels) && strtotime(end($labels)) < strtotime($labels[0])) {
            $labels = array_reverse($labels);
            $prices = array_reverse($prices);
        }

        $chartData = [
            'labels' => $labels,
            'prices' => $prices,
        ];

        return view('admin.stocks.chart', [
            'symbol' => $symbol,
            'chartData' => $chartData,
        ]);
    }

    public function show(Stock $stock)
    {
        return view('admin.stocks.show', compact('stock'));
    }

    public function exportExcel()
    {
        return Excel::download(new StocksExport, 'stock_list.xlsx');
    }

    public function exportPdf()
    {
        $stocks = Stock::all();
        $pdf = Pdf::loadView('exports.stocks_pdf', compact('stocks'));
        return $pdf->download('stock_list.pdf');
    }
}

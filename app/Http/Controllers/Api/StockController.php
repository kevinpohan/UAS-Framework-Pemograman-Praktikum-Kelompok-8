<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StockPriceService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $priceService;

    public function __construct(StockPriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    public function getChart(Request $request, $symbol)
    {
        //Menmbuat default resolution dengan permintaan 1m
        $resolution = $request->get('resolution', '1m');
        $from = $request->get('from');
        $to = $request->get('to');

        $data = $this->priceService->getHistoricalPrices($symbol, $resolution, $from, $to);

        if ($data && isset($data['c'])) {
            // Jika Twelve Data berhasil, kirim data riil
            return response()->json($data);
        } else {
            return response()->json([
                's' => 'no_data',
                // PERBAIKAN: Pesan error diperbarui agar sesuai dengan penggunaan TwelveData
                'error' => 'Failed to fetch real chart data. Check API key and subscription permissions.',
            ]);
        }
    }
}

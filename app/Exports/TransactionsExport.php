<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    public function collection()
    {
        return Transaction::with('stock')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        $user = Auth::user();

        return [
            // Baris 1: Judul Laporan
            ['TRADEINK TRANSACTION HISTORY'],
            // Baris 2: Nama User & Email
            ['User: ' . $user->name . ' (' . $user->email . ')'],
            // Baris 3: Tanggal Export
            ['Date: ' . now()->format('d M Y, H:i')],
            // Baris 4: Kosong (Spacer)
            [],
            // Baris 5: Header Tabel
            [
                'DATE',
                'TRANSACTION TYPE',
                'STOCK SYMBOL',
                'QUANTITY',
                'PRICE (USD)',
                'TOTAL VALUE (USD)'
            ]
        ];
    }

    public function map($transaction): array
    {
        $symbol = $transaction->stock ? $transaction->stock->symbol : '-';
        if ($transaction->type === 'topup') {
            $symbol = 'USD (Balance)';
        }

        return [
            $transaction->created_at->format('Y-m-d H:i'),
            strtoupper($transaction->type),
            $symbol,
            $transaction->qty ?? 0,
            $transaction->price ?? 0,
            $transaction->total,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'F' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'D' => '#,##0.0000',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = 'F';

        // --- A. STYLING HEADER LAPORAN (Baris 1-3) ---

        // Merge Cells untuk Judul Laporan agar rapi (A1 sampai F1, dst)
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');
        $sheet->mergeCells('A3:F3');

        // Style Judul Utama (TradeInk History)
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['argb' => 'FF1F2937'], // Dark Gray
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Style Info User & Tanggal
        $sheet->getStyle('A2:A3')->applyFromArray([
            'font' => [
                'size' => 11,
                'color' => ['argb' => 'FF4B5563'], // Gray-600
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT, // Rata kiri
            ],
        ]);


        // --- B. STYLING TABEL DATA (Mulai Baris 5) ---

        // Style Header Tabel (Sekarang ada di Baris 5)
        $sheet->getStyle("A5:{$highestColumn}5")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'], // Teks Putih
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1F2937'], // Background Gelap
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style Border untuk Seluruh Tabel (Dari Baris 5 sampai Bawah)
        $sheet->getStyle("A5:{$highestColumn}{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFD1D5DB'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Alignment Data (Mulai Baris 6)
        if ($highestRow >= 6) {
            $sheet->getStyle("A6:C{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D6:F{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        return [];
    }
}

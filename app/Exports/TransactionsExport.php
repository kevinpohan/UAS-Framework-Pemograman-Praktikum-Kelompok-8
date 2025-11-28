<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
        return ['Date', 'Type', 'Symbol', 'Qty', 'Price', 'Total'];
    }

    public function map($transaction): array
    {
        return [
            $transaction->created_at->format('Y-m-d H:i'),
            ucfirst($transaction->type),
            $transaction->stock ? $transaction->stock->symbol : '-',
            $transaction->qty,
            $transaction->price,
            $transaction->total,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:F' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        return [];
    }
}

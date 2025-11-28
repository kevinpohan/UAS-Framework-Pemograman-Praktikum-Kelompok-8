<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AdminTransactionsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Transaction::with(['user', 'stock'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'User Name',
            'User Email',
            'Type',
            'Stock Symbol',
            'Quantity',
            'Price',
            'Total Value',
            'Status'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->created_at->format('Y-m-d H:i:s'),
            $transaction->user->name ?? 'Deleted User',
            $transaction->user->email ?? '-',
            ucfirst($transaction->type),
            $transaction->stock ? $transaction->stock->symbol : '-',
            $transaction->qty,
            $transaction->price,
            $transaction->total,
            ucfirst($transaction->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);


        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:I' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        $sheet->getStyle('A1:I1')->getFill()->applyFromArray([
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FFFFE0',
            ],
        ]);

        return [];
    }
}

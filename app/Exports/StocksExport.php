<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class StocksExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return Stock::all();
    }

    public function headings(): array
    {
        return ['Symbol', 'Name', 'Currency', 'Visible', 'Created At'];
    }

    public function map($stock): array
    {
        return [
            $stock->symbol,
            $stock->name,
            $stock->currency,
            $stock->is_visible ? 'Yes' : 'No',
            $stock->created_at->format('Y-m-d H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:E' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        return [];
    }
}

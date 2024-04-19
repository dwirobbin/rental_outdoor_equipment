<?php

namespace App\Exports;

use App\Models\Equipment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EquipmentExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $index = 0;

    protected array $selectedRows;
    protected string $sortColumn;
    protected string $sortDirection;

    public function __construct(array $selectedRows, string $sortColumn, string $sortDirection)
    {
        $this->selectedRows = $selectedRows;
        $this->sortColumn = $sortColumn;
        $this->sortDirection = $sortDirection;
    }

    public function headings(): array
    {
        return [
            'No.',
            'Nama',
            'Harga',
            'Stok',
        ];
    }

    public function map($equipment): array
    {
        return [
            ++$this->index,
            $equipment->name,
            $equipment->price,
            $equipment->stock == 0 ? '0' : $equipment->stock,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(1)->applyFromArray([
            'font' => [
                'name' => 'Arial',
                'size' => 11,
                'bold' => true,
                'italic' => false,
                'underline' => Font::UNDERLINE_SINGLE,
                'strikethrough' => false,
                'color' => [
                    'rgb' => Color::COLOR_BLACK
                ],
            ],
        ]);
    }

    public function query()
    {
        return Equipment::query()
            ->whereIn('id', $this->selectedRows)
            ->orderBy($this->sortColumn, $this->sortDirection);
    }
}

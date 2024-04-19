<?php

namespace App\Exports;

use App\Models\Billing;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BillingExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'ID Order#',
            'Tgl Dibuat',
            'Tgl Jatuh Tempo',
            'Total Bayar',
            'Status',
        ];
    }

    public function map($model): array
    {
        return [
            ++$this->index,
            $model->order->order_code,
            $model->created_date->format('d/m/Y'),
            $model->due_date->format('d/m/Y'),
            $model->total,
            $model->status,
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
        return Billing::query()
            ->select(['billings.*'])
            ->join('orders', 'billings.order_id', '=', 'orders.id')
            ->whereIn('billings.id', $this->selectedRows)
            ->orderBy($this->sortColumn, $this->sortDirection);
    }
}

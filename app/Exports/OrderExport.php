<?php

namespace App\Exports;

use App\Models\Order;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OrderExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'Nama Penyewa',
            'Tgl Sewa',
            'Tgl Berakhir',
            'Jmlh yg disewa',
            'Status',
        ];
    }

    public function map($model): array
    {
        return [
            ++$this->index,
            $model->order_code,
            $model->orderedBy->name,
            $model->start_date->format('d/m/Y'),
            $model->end_date->format('d/m/Y'),
            $model->amount . ' Alat',
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
        return Order::query()
            ->selectRaw("
                orders.*, SUM(order_details.amount) AS amount
            ")
            ->join('users', 'orders.ordered_by', '=', 'users.id')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->groupBy('order_details.order_id')
            ->whereIn('orders.id', $this->selectedRows)
            ->orderBy($this->sortColumn, $this->sortDirection);
    }
}

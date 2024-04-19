<?php

namespace App\Exports;

use App\Models\User;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'Username',
            'Email',
            'Peran',
            'Status Akun',
        ];
    }

    public function map($model): array
    {
        return [
            ++$this->index,
            $model->name,
            $model->username,
            $model->email,
            $model->role->name,
            $model->is_active == 1 ? 'Aktif' : 'Tidak Aktif',
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
        return User::query()
            ->with('role')
            ->whereIn('id', $this->selectedRows)
            ->orderBy($this->sortColumn, $this->sortDirection);
    }
}

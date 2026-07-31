<?php

namespace App\Exports;

use App\Models\RevenueSharing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RevenueExport implements FromCollection, WithHeadings, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = RevenueSharing::query()
            ->with(['payment', 'mitra'])
            ->select(['id', 'booking_type', 'payment_id', 'mitra_id', 'admin_amount', 'mitra_amount', 'driver_amount', 'status', 'created_at']);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get()->map(function ($revenue) {
            $total = $revenue->admin_amount + $revenue->mitra_amount + $revenue->driver_amount;
            return [
                $revenue->id,
                ucfirst($revenue->booking_type),
                'Rp ' . number_format($total, 0, ',', '.'),
                'Rp ' . number_format($revenue->admin_amount, 0, ',', '.'),
                'Rp ' . number_format($revenue->mitra_amount, 0, ',', '.'),
                'Rp ' . number_format($revenue->driver_amount, 0, ',', '.'),
                $revenue->mitra->name ?? '-',
                ucfirst($revenue->status),
                $revenue->created_at->format('d-m-Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Type',
            'Total Revenue',
            'Admin Share',
            'Mitra Share',
            'Driver Share',
            'Mitra Name',
            'Status',
            'Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '22C55E']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}

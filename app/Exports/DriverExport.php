<?php

namespace App\Exports;

use App\Models\Driver;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DriverExport implements FromCollection, WithHeadings, WithStyles
{
    protected $companyId;

    public function __construct($companyId = null)
    {
        $this->companyId = $companyId;
    }

    public function collection()
    {
        $query = Driver::query()->with('user');

        if ($this->companyId) {
            $query->whereHas('user', function($q) {
                $q->where('company_id', $this->companyId);
            });
        }

        return $query->get()->map(function ($driver) {
            return [
                $driver->user->name ?? '-',
                $driver->user->phone ?? '-',
                $driver->license_number ?? '-',
                $driver->vehicle_type ?? '-',
                'Rp ' . number_format($driver->total_earnings ?? 0, 0, ',', '.'),
                $driver->rating ?? 0,
                $driver->trip_count ?? 0,
                $driver->user->is_active ? 'Active' : 'Inactive',
                $driver->created_at->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Phone',
            'License Number',
            'Vehicle Type',
            'Total Earnings',
            'Rating',
            'Trips',
            'Status',
            'Joined Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'F59E0B']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\TravelBooking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BookingExport implements FromCollection, WithHeadings, WithStyles, WithColumnFormatting
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
        $query = TravelBooking::query()
            ->with(['user', 'route', 'payments'])
            ->select([
                'id',
                'booking_code',
                'user_id',
                'route_id',
                'number_of_seats',
                'total_price',
                'status',
                'scheduled_date',
                'created_at'
            ]);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->get()->map(function ($booking) {
            return [
                $booking->booking_code,
                $booking->user->name ?? '-',
                $booking->user->email ?? '-',
                $booking->route->from_location->city . ' → ' . $booking->route->to_location->city,
                $booking->number_of_seats,
                'Rp ' . number_format($booking->total_price, 0, ',', '.'),
                ucfirst($booking->status),
                $booking->scheduled_date->format('d-m-Y'),
                $booking->created_at->format('d-m-Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Booking Code',
            'Customer Name',
            'Email',
            'Route',
            'Seats',
            'Total Price',
            'Status',
            'Scheduled Date',
            'Created At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '2563EB']],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_CURRENCY_IDR,
        ];
    }
}

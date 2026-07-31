<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\RevenueSharing;
use App\Models\TravelBooking;
use App\Models\RentalBooking;

class RevenueShareService
{
    private const ADMIN_PERCENTAGE = 30;
    private const MITRA_PERCENTAGE = 50;
    private const DRIVER_PERCENTAGE = 20;

    /**
     * Create revenue sharing for travel booking
     */
    public function createTravelRevenueSharing(TravelBooking $booking, Payment $payment): RevenueSharing
    {
        $totalAmount = $payment->amount;

        $adminAmount = ($totalAmount * self::ADMIN_PERCENTAGE) / 100;
        $mitraAmount = ($totalAmount * self::MITRA_PERCENTAGE) / 100;
        $driverAmount = ($totalAmount * self::DRIVER_PERCENTAGE) / 100;

        $armada = $booking->assignedArmada;
        if (!$armada) {
            throw new \Exception('Armada not assigned for booking');
        }

        return RevenueSharing::create([
            'booking_id' => $booking->id,
            'booking_type' => TravelBooking::class,
            'payment_id' => $payment->id,
            'mitra_id' => $armada->mitra_id,
            'admin_amount' => $adminAmount,
            'mitra_amount' => $mitraAmount,
            'driver_amount' => $driverAmount,
            'admin_percentage' => self::ADMIN_PERCENTAGE,
            'mitra_percentage' => self::MITRA_PERCENTAGE,
            'driver_percentage' => self::DRIVER_PERCENTAGE,
            'status' => 'pending',
        ]);
    }

    /**
     * Create revenue sharing for rental booking
     */
    public function createRentalRevenueSharing(RentalBooking $booking, Payment $payment): RevenueSharing
    {
        $totalAmount = $payment->amount;
        $armada = $booking->assignedArmada;

        if (!$armada) {
            throw new \Exception('Armada not assigned for booking');
        }

        // If rental without driver, adjust percentages
        if ($booking->rental_type === 'without_driver') {
            $adminPercentage = 50;
            $mitraPercentage = 50;
            $driverPercentage = 0;
        } else {
            $adminPercentage = self::ADMIN_PERCENTAGE;
            $mitraPercentage = self::MITRA_PERCENTAGE;
            $driverPercentage = self::DRIVER_PERCENTAGE;
        }

        $adminAmount = ($totalAmount * $adminPercentage) / 100;
        $mitraAmount = ($totalAmount * $mitraPercentage) / 100;
        $driverAmount = ($totalAmount * $driverPercentage) / 100;

        return RevenueSharing::create([
            'booking_id' => $booking->id,
            'booking_type' => RentalBooking::class,
            'payment_id' => $payment->id,
            'mitra_id' => $armada->mitra_id,
            'admin_amount' => $adminAmount,
            'mitra_amount' => $mitraAmount,
            'driver_amount' => $driverAmount,
            'admin_percentage' => $adminPercentage,
            'mitra_percentage' => $mitraPercentage,
            'driver_percentage' => $driverPercentage,
            'status' => 'pending',
        ]);
    }

    /**
     * Complete revenue sharing (distrubute earnings)
     */
    public function completeRevenueSharing(RevenueSharing $revenueSharing): RevenueSharing
    {
        $revenueSharing->markAsCompleted();
        return $revenueSharing;
    }

    /**
     * Get total earnings by mitra
     */
    public function getMitraEarnings($mitraId): array
    {
        $sharings = RevenueSharing::where('mitra_id', $mitraId)
                                 ->where('status', 'completed')
                                 ->get();

        $totalEarnings = $sharings->sum('mitra_amount');
        $totalTransactions = $sharings->count();

        return [
            'total_earnings' => $totalEarnings,
            'total_transactions' => $totalTransactions,
            'average_earning' => $totalTransactions > 0 ? $totalEarnings / $totalTransactions : 0,
        ];
    }

    /**
     * Get pending revenue sharings
     */
    public function getPendingSharings()
    {
        return RevenueSharing::where('status', 'pending')->get();
    }
}

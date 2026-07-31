<?php

namespace App\Services;

use App\Models\RentalBooking;
use App\Models\Route;
use Illuminate\Support\Str;

class RentalBookingService
{
    /**
     * Create a new rental booking
     */
    public function createBooking(
        int $userId,
        int $routeId,
        string $rentalType,
        int $regencyCount,
        string $startDate
    ): RentalBooking {
        $route = Route::findOrFail($routeId);
        $rentalPrice = $route->getRentalPrice();

        if (!$rentalPrice) {
            throw new \Exception('Rental price not available for this route');
        }

        $basePrice = $rentalPrice->price_without_driver;
        $driverFee = 0;

        if ($rentalType === 'with_driver') {
            $driverFee = $regencyCount * $rentalPrice->driver_fee_per_regency;
        }

        $totalPrice = $basePrice + $driverFee;

        return RentalBooking::create([
            'user_id' => $userId,
            'route_id' => $routeId,
            'rental_type' => $rentalType,
            'regency_count' => $regencyCount,
            'base_price' => $basePrice,
            'driver_fee' => $driverFee,
            'total_price' => $totalPrice,
            'booking_code' => $this->generateBookingCode(),
            'status' => 'pending',
            'start_date' => $startDate,
        ]);
    }

    /**
     * Confirm a rental booking and assign armada
     */
    public function confirmBooking(RentalBooking $booking, int $armadaId): RentalBooking
    {
        $armada = \App\Models\Armada::findOrFail($armadaId);

        if (!$armada->isAvailable()) {
            throw new \Exception('Armada is not available');
        }

        $booking->update([
            'assigned_armada_id' => $armadaId,
            'status' => 'confirmed',
        ]);

        $armada->setToJalan();

        return $booking;
    }

    /**
     * Complete a rental booking
     */
    public function completeBooking(RentalBooking $booking): RentalBooking
    {
        $booking->update(['status' => 'completed']);

        // Set armada back to available
        if ($booking->assigned_armada_id) {
            $booking->assignedArmada->setToAvailable();
        }

        return $booking;
    }

    /**
     * Cancel a rental booking
     */
    public function cancelBooking(RentalBooking $booking): RentalBooking
    {
        if (!$booking->canBeCancelled()) {
            throw new \Exception('Booking cannot be cancelled in current status');
        }

        $booking->cancel();

        // Set armada back to available if assigned
        if ($booking->assigned_armada_id && $booking->assignedArmada->status === 'jalan') {
            $booking->assignedArmada->setToAvailable();
        }

        return $booking;
    }

    /**
     * Generate booking code
     */
    private function generateBookingCode(): string
    {
        $prefix = 'RB'; // Rental Booking
        $timestamp = now()->format('YmdHis');
        $random = strtoupper(Str::random(6));

        return "{$prefix}{$timestamp}{$random}";
    }

    /**
     * Calculate total price
     */
    public function calculatePrice(
        float $basePrice,
        string $rentalType,
        int $regencyCount,
        float $driverFeePerRegency
    ): array {
        $driverFee = 0;

        if ($rentalType === 'with_driver') {
            $driverFee = $regencyCount * $driverFeePerRegency;
        }

        $totalPrice = $basePrice + $driverFee;

        return [
            'base_price' => $basePrice,
            'driver_fee' => $driverFee,
            'total_price' => $totalPrice,
        ];
    }
}

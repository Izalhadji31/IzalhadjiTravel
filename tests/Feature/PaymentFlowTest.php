<?php

namespace Tests\Feature;

use App\Models\Location;
use App\Models\Route;
use App\Models\TravelBooking;
use App\Models\TravelPrice;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_notification_confirms_booking_and_updates_payment_status(): void
    {
        $user = User::factory()->create();
        $from = Location::factory()->create();
        $to = Location::factory()->create();
        $route = Route::factory()->create([
            'from_location_id' => $from->id,
            'to_location_id' => $to->id,
            'base_price' => 100000,
        ]);
        TravelPrice::create([
            'route_id' => $route->id,
            'price_per_seat' => 100000,
            'is_active' => true,
        ]);

        $booking = TravelBooking::factory()->create([
            'user_id' => $user->id,
            'route_id' => $route->id,
            'number_of_seats' => 2,
            'total_price' => 200000,
            'final_price' => 200000,
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);

        $service = app(PaymentService::class);
        $payment = $service->recordPayment($booking, 'travel', 'TRV-TEST-001', 'snap-token');

        $result = $service->handleNotification([
            'order_id' => 'TRV-TEST-001',
            'transaction_status' => 'settlement',
            'payment_type' => 'credit_card',
            'transaction_id' => 'txn-123',
        ]);

        $this->assertTrue($result['success']);
        $payment->refresh();
        $booking->refresh();

        $this->assertSame('success', $payment->status);
        $this->assertSame('confirmed', $booking->status);
    }
}

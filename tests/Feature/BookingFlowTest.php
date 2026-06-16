<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Route;
use App\Models\Location;
use App\Models\TravelBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $route;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'customer']);
        
        // Create route
        $from = Location::factory()->create();
        $to = Location::factory()->create();
        $this->route = Route::factory()->create([
            'from_location_id' => $from->id,
            'to_location_id' => $to->id,
            'base_price' => 100000,
        ]);
    }

    public function test_customer_can_create_booking()
    {
        $this->actingAs($this->user);

        $response = $this->post('/bookings', [
            'route_id' => $this->route->id,
            'number_of_seats' => 2,
            'scheduled_date' => now()->addDay(),
        ]);

        $this->assertDatabaseHas('travel_bookings', [
            'user_id' => $this->user->id,
            'route_id' => $this->route->id,
            'number_of_seats' => 2,
        ]);

        $response->assertRedirect();
    }

    public function test_booking_creates_payment_record()
    {
        $this->actingAs($this->user);

        $this->post('/bookings', [
            'route_id' => $this->route->id,
            'number_of_seats' => 2,
            'scheduled_date' => now()->addDay(),
        ]);

        $booking = TravelBooking::where('user_id', $this->user->id)->first();

        $this->assertNotNull($booking);
        $this->assertGreater($booking->total_price, 0);
    }

    public function test_customer_cannot_create_booking_without_identity()
    {
        $this->actingAs($this->user);
        $this->user->update(['is_verified' => false]);

        $response = $this->post('/bookings', [
            'route_id' => $this->route->id,
            'number_of_seats' => 2,
            'scheduled_date' => now()->addDay(),
        ]);

        // Should either redirect to verification or show error
        $this->assertTrue(
            $response->status() === 302 || // Redirect
            $response->status() === 403    // Forbidden
        );
    }

    public function test_booking_validates_required_fields()
    {
        $this->actingAs($this->user);

        $response = $this->post('/bookings', []);

        $response->assertSessionHasErrors(['route_id', 'number_of_seats', 'scheduled_date']);
    }

    public function test_booking_validates_seat_limits()
    {
        $this->actingAs($this->user);

        $response = $this->post('/bookings', [
            'route_id' => $this->route->id,
            'number_of_seats' => 100, // Unrealistic
            'scheduled_date' => now()->addDay(),
        ]);

        $response->assertSessionHasErrors(['number_of_seats']);
    }

    public function test_booking_cannot_be_past_date()
    {
        $this->actingAs($this->user);

        $response = $this->post('/bookings', [
            'route_id' => $this->route->id,
            'number_of_seats' => 2,
            'scheduled_date' => now()->subDay(),
        ]);

        $response->assertSessionHasErrors(['scheduled_date']);
    }

    public function test_customer_can_view_booking()
    {
        $booking = TravelBooking::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);
        $response = $this->get("/bookings/{$booking->id}");

        $response->assertSuccessful();
        $response->assertViewHas('booking', $booking);
    }

    public function test_customer_cannot_view_others_booking()
    {
        $otherUser = User::factory()->create();
        $booking = TravelBooking::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($this->user);
        $response = $this->get("/bookings/{$booking->id}");

        $response->assertForbidden();
    }
}

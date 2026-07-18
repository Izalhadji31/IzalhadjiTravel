<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_user_can_register()
    {
        $this->mock(\App\Services\WhatsAppService::class, function ($mock) {
            $mock->shouldReceive('send')->andReturn(true);
        });

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '08123456789',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'customer',
        ]);

        $response->assertRedirect();
        $pending = session('register.pending');
        $this->assertNotNull($pending);

        $response2 = $this->post('/register/verify-otp', [
            'otp' => $pending['otp'],
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);
    }

    public function test_registration_validates_email()
    {
        User::factory()->create(['email' => 'test@example.com']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '08123456789',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'customer',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->post('/logout');

        $this->assertGuest();
    }

    public function test_different_roles_redirect_correctly()
    {
        $customerUser = User::factory()->create(['role' => 'customer']);
        $adminUser = User::factory()->create(['role' => 'admin']);
        $driverUser = User::factory()->create(['role' => 'driver']);

        $this->actingAs($customerUser);
        $response = $this->get('/dashboard');
        $response->assertViewIs('dashboard.customer');

        $this->actingAs($adminUser);
        $response = $this->get('/dashboard');
        $response->assertRedirect(route('admin.dashboard'));

        $this->actingAs($driverUser);
        $response = $this->get('/dashboard');
        $response->assertViewIs('dashboard.driver');
    }
}

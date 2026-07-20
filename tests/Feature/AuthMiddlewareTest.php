<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_is_forbidden_from_admin_web_routes(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $this->actingAs($user);
        $response = $this->get('/admin');

        $response->assertForbidden();
    }

    public function test_api_admin_routes_return_forbidden_json_for_non_admin_user(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/admin/routes');

        $response->assertStatus(403)
            ->assertJsonPath('code', 'FORBIDDEN');
    }

    public function test_partner_is_forbidden_from_admin_web_routes(): void
    {
        $user = User::factory()->create(['role' => 'partner']);

        $this->actingAs($user);
        $response = $this->get('/admin');

        $response->assertForbidden();
    }

    public function test_admin_can_access_admin_area(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user);
        $response = $this->get('/admin');

        $response->assertSuccessful();
    }

    public function test_unavailable_admin_area_route_returns_not_found(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user);
        $response = $this->get('/legacy-admin-area');

        $response->assertNotFound();
    }
}

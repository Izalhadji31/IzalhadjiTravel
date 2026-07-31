<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_edit_own_profile()
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'is_verified' => true,
        ]);
        $customer->assignRole('customer');

        $this->actingAs($customer)
            ->get('/profile/edit')
            ->assertStatus(200);
    }

    public function test_driver_can_edit_own_profile()
    {
        $driver = User::factory()->create([
            'role' => 'driver',
            'is_verified' => true,
        ]);
        $driver->assignRole('driver');

        $this->actingAs($driver)
            ->get('/profile/edit')
            ->assertStatus(200);
    }

    public function test_partner_can_edit_own_profile()
    {
        $partner = User::factory()->create([
            'role' => 'partner',
            'is_verified' => true,
        ]);
        $partner->assignRole('partner');

        $this->actingAs($partner)
            ->get('/profile/edit')
            ->assertStatus(200);
    }

    public function test_admin_has_full_access()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'is_verified' => true,
        ]);
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertStatus(200);
    }

    public function test_super_admin_has_full_access()
    {
        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'is_verified' => true,
        ]);
        $superAdmin->assignRole('super_admin');

        $this->actingAs($superAdmin)
            ->get('/admin/dashboard')
            ->assertStatus(200);
    }
}
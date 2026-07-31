<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Remove old 'user' role if it exists (replaced by 'customer')
        $oldUserRole = Role::where('name', 'user')->where('guard_name', 'web')->first();
        if ($oldUserRole) {
            $oldUserRole->delete();
        }

        // Define Permissions
        $permissions = [
            // User Management
            'view_users',
            'create_user',
            'edit_user',
            'delete_user',
            'verify_identity',
            'suspend_user',
            'edit_own_profile',

            // Travel Management
            'view_travels',
            'create_travel',
            'edit_travel',
            'delete_travel',
            'manage_travel_bookings',
            'assign_travel_vehicle',
            'assign_travel_driver',

            // Rental Management
            'view_rentals',
            'create_rental',
            'edit_rental',
            'delete_rental',
            'manage_rental_bookings',
            'assign_rental_vehicle',
            'assign_rental_driver',

            // Vehicle Management
            'view_vehicles',
            'create_vehicle',
            'edit_vehicle',
            'delete_vehicle',
            'manage_maintenance',
            'view_vehicle_utilization',
            'view_vehicle_location',

            // Driver Management
            'view_drivers',
            'create_driver',
            'edit_driver',
            'delete_driver',
            'manage_driver_tracking',

            // Partner Management
            'view_partners',
            'create_partner',
            'edit_partner',
            'delete_partner',
            'view_partner_revenue',
            'view_partner_financial_reports',

            // Payment Management
            'view_payments',
            'process_payment',
            'process_refund',
            'manage_vouchers',

            // Reports & Analytics
            'view_reports',
            'export_reports',
            'view_analytics',

            // Settings
            'manage_settings',
            'manage_cms',
            'view_audit_logs',

            // Review & Rating
            'view_reviews',
            'delete_review',
            'moderate_reviews',

            // Booking Management
            'view_all_bookings',
            'manage_bookings',
            'cancel_booking',

            // Driver Trip Management
            'accept_trip',
            'start_trip',
            'complete_trip',
            'view_available_trips',
        ];

        // Create Permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Create Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $partner = Role::firstOrCreate(['name' => 'partner', 'guard_name' => 'web']);
        $driver = Role::firstOrCreate(['name' => 'driver', 'guard_name' => 'web']);
        $customer = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);

        // Super Admin - All Permissions
        $superAdmin->syncPermissions(Permission::all());

        // Admin - Full access (all permissions)
        $admin->syncPermissions(Permission::all());

        // Partner (Mitra) - revenue & reports + limited operational visibility
        // Updated per requirements: utilisasi/lokasi mobil dipakai dan laporan keuangan
        $partner->syncPermissions([
            'view_partner_revenue',
            'view_partner_financial_reports',
            'view_reports',
            'export_reports',
            'view_analytics',
            'view_vehicles',
            'view_vehicle_utilization',
            'view_vehicle_location',
            'view_drivers',
            'view_payments',
            'view_reviews',
            'edit_own_profile',
        ]);

        // Driver (Sopir) - accept/start/complete trip
        // Updated per requirements: accept/start/complete trip permissions
        $driver->syncPermissions([
            'view_analytics',
            'manage_driver_tracking',
            'accept_trip',
            'start_trip',
            'complete_trip',
            'view_available_trips',
            'edit_own_profile',
        ]);

        // Customer (Customer/Guest) - booking & view availability
        // Updated role name from 'user' to 'customer' to match demo users
        // Requirement: customer hanya memesan + melihat ketersediaan.
        $customer->syncPermissions([
            'view_travels',
            'view_rentals',
            'manage_bookings',
            'cancel_booking',
            'edit_own_profile',
        ]);
    }
}


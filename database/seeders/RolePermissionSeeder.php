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

        // Define Permissions
        $permissions = [
            // User Management
            'view_users',
            'create_user',
            'edit_user',
            'delete_user',
            'verify_identity',
            'suspend_user',

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
        $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Assign Permissions to Roles
        
        // Super Admin - All Permissions
        $superAdmin->syncPermissions(Permission::all());

        // Admin - Management Permissions
        $admin->syncPermissions([
            'view_users', 'create_user', 'edit_user', 'delete_user', 'verify_identity', 'suspend_user',
            'view_travels', 'create_travel', 'edit_travel', 'delete_travel', 'manage_travel_bookings',
            'assign_travel_vehicle', 'assign_travel_driver',
            'view_rentals', 'create_rental', 'edit_rental', 'delete_rental', 'manage_rental_bookings',
            'assign_rental_vehicle', 'assign_rental_driver',
            'view_vehicles', 'create_vehicle', 'edit_vehicle', 'delete_vehicle', 'manage_maintenance',
            'view_drivers', 'create_driver', 'edit_driver', 'delete_driver', 'manage_driver_tracking',
            'view_partners', 'create_partner', 'edit_partner', 'delete_partner',
            'view_payments', 'process_payment', 'process_refund', 'manage_vouchers',
            'view_reports', 'export_reports', 'view_analytics',
            'manage_settings', 'manage_cms', 'view_audit_logs',
            'view_reviews', 'delete_review', 'moderate_reviews',
            'view_all_bookings', 'manage_bookings', 'cancel_booking',
        ]);

        // Partner - Own Fleet & Revenue Management
        $partner->syncPermissions([
            'view_vehicles', 'view_drivers', 'view_partner_revenue',
            'view_all_bookings', 'manage_bookings', 'view_payments',
            'view_reviews', 'view_reports', 'export_reports',
        ]);

        // Driver - Own Trip Management
        $driver->syncPermissions([
            'view_analytics', 'manage_driver_tracking',
        ]);

        // User - Booking Management
        $user->syncPermissions([
            'view_travels', 'view_rentals', 'manage_bookings',
        ]);
    }
}

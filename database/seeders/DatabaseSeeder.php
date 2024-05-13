<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Medication;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $owner = User::factory()->create([
            'name' => 'Admin Owner',
            'email' => 'owner@admin.com',
            'username' => 'owner',
            'role' => 'owner'
        ]);

        // Create a Manager
        User::factory()->create([
            'name' => 'Admin Manager',
            'email' => 'manager@admin.com',
            'username' => 'manager',
            'role' => 'manager'
        ]);

        // Create a Cashier
        User::factory()->create([
            'name' => 'Admin Cashier',
            'email' => 'cashier@admin.com',
            'username' => 'cashier',
            'role' => 'cashier'
        ]);

        Customer::factory(20)->create([
            'created_by' => $owner->id
        ]);

        Medication::factory(20)->create([
            'created_by' => $owner->id
        ]);
    }
}

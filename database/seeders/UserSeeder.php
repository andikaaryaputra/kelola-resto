<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Restaurant',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'administrator',
        ]);

        // Waiter 1
        User::create([
            'name' => 'Waiter 1',
            'email' => 'waiter1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'waiter',
        ]);

        // Waiter 2
        User::create([
            'name' => 'Waiter 2',
            'email' => 'waiter2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'waiter',
        ]);

        // Kasir
        User::create([
            'name' => 'Kasir Restaurant',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        // Owner
        User::create([
            'name' => 'Owner Restaurant',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);
    }
}
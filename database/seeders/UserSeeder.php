<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@ecosflooring.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'timezone' => 'UTC',
                'locale' => 'en'
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@ecosflooring.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'timezone' => 'UTC',
                'locale' => 'en'
            ],
            [
                'name' => 'Shop Manager',
                'email' => 'manager@ecosflooring.com',
                'password' => Hash::make('password'),
                'role' => 'shop_manager',
                'timezone' => 'UTC',
                'locale' => 'en'
            ],
            [
                'name' => 'VIP Customer',
                'email' => 'vip@example.com',
                'password' => Hash::make('password'),
                'role' => 'vip_buyer',
                'timezone' => 'UTC',
                'locale' => 'en'
            ],
            [
                'name' => 'Commercial Customer',
                'email' => 'commercial@example.com',
                'password' => Hash::make('password'),
                'role' => 'commercial_buyer',
                'timezone' => 'UTC',
                'locale' => 'en'
            ],
            [
                'name' => 'Regular Customer',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'timezone' => 'UTC',
                'locale' => 'en'
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }
    }
}

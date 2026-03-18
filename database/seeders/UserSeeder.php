<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
        ['email' => 'admin@bloodbank.com'],
        [
            'name' => 'Admin',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]
        );

        User::firstOrCreate(
            ['email' => 'doctor@bloodbank.com'],
            [
                'name' => 'Dr. House',
                'password' => bcrypt('doctor123'),
                'role' => 'doctor',
            ]
        );

        User::firstOrCreate(
            ['email' => 'nurse@bloodbank.com'],
            [
                'name' => 'Infirmier',
                'password' => bcrypt('nurse123'),
                'role' => 'nurse',
            ]
        );

    }
}

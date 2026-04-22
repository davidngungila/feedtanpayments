<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@feedtanpay.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create a staff user for testing
        User::create([
            'name' => 'Staff User',
            'email' => 'staff@feedtanpay.com',
            'password' => Hash::make('staff123'),
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin and Staff users created successfully!');
        $this->command->info('Admin: admin@feedtanpay.com / admin123');
        $this->command->info('Staff: staff@feedtanpay.com / staff123');
    }
}

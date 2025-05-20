<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Check if admin already exists
        $admin = User::where('staff_id', 'Adm00001')->first();
        if (!$admin) {
            User::create([
                'name' => 'Default Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('StrongPassword123!'), // Replace with your secure default
                'role_id' => 1, // Assuming 1 is admin role
                'department_id' => null, // Optional, depends on your setup
                'staff_id' => 'Adm00001',
                'force_password_reset' => true, // Force admin to change password on first login
            ]);
        }
    }
}

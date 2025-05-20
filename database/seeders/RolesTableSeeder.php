<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Make sure this model exists

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Admin', 'Pharmacy', 'Record', 'Nurse', 'Doctor'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }
    }
}

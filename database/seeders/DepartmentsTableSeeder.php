<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = ['Admin', 'Pharmacy', 'Record', 'Nurse', 'Doctor'];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['name' => $dept]);
        }
    }
}

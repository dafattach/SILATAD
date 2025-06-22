<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'employee_position_id' => 1,
            'department_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@silatad.test',
            'registration_type' => 'NIP',
            'registration_number' => '00000000001',
            'password' => Hash::make('pastibisa'),
        ]);

        Employee::create([
            'employee_position_id' => 7,
            'department_id' => 1,
            'name' => 'staff',
            'email' => 'staff@silatad.test',
            'registration_type' => 'NIP',
            'registration_number' => '00000000002',
            'password' => Hash::make('pastibisa'),
        ]);

        Employee::create([
            'employee_position_id' => 7,
            'department_id' => 1,
            'name' => 'staff 1',
            'email' => 'staff1@silatad.test',
            'registration_type' => 'NIP',
            'registration_number' => '00000000003',
            'password' => Hash::make('pastibisa'),
        ]);

        Employee::create([
            'employee_position_id' => 2,
            'department_id' => 1,
            'name' => 'dekan',
            'email' => 'dekan@silatad.test',
            'registration_type' => 'NIP',
            'registration_number' => '00000000004',
            'password' => Hash::make('pastibisa'),
        ]);
    }
}

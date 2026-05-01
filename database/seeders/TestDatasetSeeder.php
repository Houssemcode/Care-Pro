<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Family;
use App\Models\Offre;
use App\Models\Request;
use Illuminate\Support\Facades\Hash;

class TestDatasetSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin
        $adminUser = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@carepro.dz',
            'password' => Hash::make('password'),
            'phone' => '0550000000',
        ]);
        Admin::create(['user_id' => $adminUser->id]);

        // 2. Create Employees
        $employees = [];
        $employeeData = [
            ['name' => 'Amel Benali', 'email' => 'amel@example.com', 'exp' => '5 years', 'diploma' => 'Nursing Degree', 'desc' => 'Specialized in elderly care'],
            ['name' => 'Sami Mansouri', 'email' => 'sami@example.com', 'exp' => '3 years', 'diploma' => 'Child Psychology', 'desc' => 'Expert in early childhood development'],
            ['name' => 'Layla Haddad', 'email' => 'layla@example.com', 'exp' => '10 years', 'diploma' => 'Medical Assistant', 'desc' => 'Experienced in home healthcare'],
            ['name' => 'Karim Ziane', 'email' => 'karim@example.com', 'exp' => '2 years', 'diploma' => 'Caregiver Certificate', 'desc' => 'Passionate about helping families'],
            ['name' => 'Sonia Rahmani', 'email' => 'sonia@example.com', 'exp' => '7 years', 'diploma' => 'Pediatrics', 'desc' => 'Dedicated child care professional'],
        ];

        foreach ($employeeData as $data) {
            $user = User::factory()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'phone' => '05' . rand(10000000, 99999999),
            ]);
            $emp = Employee::create([
                'user_id' => $user->id,
                'experience' => $data['exp'],
                'diploma' => $data['diploma'],
                'description' => $data['desc'],
                'status' => 'active',
            ]);
            $employees[] = $emp;
        }

        // 3. Create Families
        $families = [];
        $familyData = [
            ['name' => 'Family Ahmed', 'email' => 'ahmed@family.com'],
            ['name' => 'Family Sarah', 'email' => 'sarah@family.com'],
            ['name' => 'Family Mourad', 'email' => 'mourad@family.com'],
            ['name' => 'Family Leila', 'email' => 'leila@family.com'],
            ['name' => 'Family Omar', 'email' => 'omar@family.com'],
        ];

        foreach ($familyData as $data) {
            $user = User::factory()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'phone' => '06' . rand(10000000, 99999999),
            ]);
            $families[] = Family::create(['user_id' => $user->id]);
        }

        // 4. Create Offres (Offers)
        $wilayas = ['Algiers', 'Oran', 'Constantine', 'Sétif', 'Tlemcen'];
        $communes = ['Center', 'East', 'West', 'North', 'South'];
        $offres = [];

        foreach ($employees as $emp) {
            // Each employee creates 2 offers
            for ($i = 0; $i < 2; $i++) {
                $offres[] = Offre::create([
                    'employee_id' => $emp->id,
                    'wilaya' => $wilayas[array_rand($wilayas)],
                    'commune' => $communes[array_rand($communes)],
                    'service_type' => rand(0, 1) ? 'Child Care' : 'Elderly Care',
                    'working_house' => (bool)rand(0, 1),
                ]);
            }
        }

        // 5. Create Requests
        $statuses = ['pending', 'assigned', 'rejected'];
        foreach ($families as $family) {
            // Each family makes 3 requests
            for ($i = 0; $i < 3; $i++) {
                Request::create([
                    'family_id' => $family->id,
                    'offre_id' => $offres[array_rand($offres)]->id,
                    'start_date' => now()->addDays(rand(1, 30)),
                    'end_date' => now()->addDays(rand(31, 60)),
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }
    }
}

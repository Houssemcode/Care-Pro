<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Family;
use App\Models\Localization;
use App\Models\Offre;
use App\Models\Request;
use App\Models\AssignmentService;
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

        // 2. Create Employees (with localization for Near Me feature)
        $employees = [];
        $employeeData = [
            ['name' => 'Amel Benali',    'email' => 'amel@example.com',  'exp' => '5 years',  'diploma' => 'Nursing Degree',       'desc' => 'Specialized in elderly care',          'wilaya' => 'Algiers',     'commune' => 'Bab El Oued',    'lat' => 36.7920, 'lng' => 3.0510],
            ['name' => 'Sami Mansouri',  'email' => 'sami@example.com',  'exp' => '3 years',  'diploma' => 'Child Psychology',      'desc' => 'Expert in early childhood development', 'wilaya' => 'Algiers',     'commune' => 'Hydra',          'lat' => 36.7380, 'lng' => 3.0350],
            ['name' => 'Layla Haddad',   'email' => 'layla@example.com', 'exp' => '10 years', 'diploma' => 'Medical Assistant',     'desc' => 'Experienced in home healthcare',        'wilaya' => 'Oran',        'commune' => 'Oran Centre',    'lat' => 35.6971, 'lng' => -0.6308],
            ['name' => 'Karim Ziane',    'email' => 'karim@example.com', 'exp' => '2 years',  'diploma' => 'Caregiver Certificate', 'desc' => 'Passionate about helping families',     'wilaya' => 'Constantine', 'commune' => 'El Khroub',      'lat' => 36.2639, 'lng' => 6.6934],
            ['name' => 'Sonia Rahmani',  'email' => 'sonia@example.com', 'exp' => '7 years',  'diploma' => 'Pediatrics',            'desc' => 'Dedicated child care professional',     'wilaya' => 'Algiers',     'commune' => 'Bir Mourad Rais','lat' => 36.7162, 'lng' => 3.0497],
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
            // Create localization record so "Near Me" works
            Localization::create([
                'user_id' => $user->id,
                'wilaya' => $data['wilaya'],
                'commune' => $data['commune'],
                'latitude' => $data['lat'],
                'logitude' => $data['lng'],
            ]);
            $employees[] = $emp;
        }

        // 3. Create Families (with localization for Near Me feature)
        $families = [];
        $familyData = [
            ['name' => 'Family Ahmed', 'email' => 'ahmed@family.com',  'wilaya' => 'Algiers',     'commune' => 'Kouba',          'lat' => 36.7268, 'lng' => 3.0850],
            ['name' => 'Family Sarah', 'email' => 'sarah@family.com',  'wilaya' => 'Algiers',     'commune' => 'El Biar',        'lat' => 36.7690, 'lng' => 3.0304],
            ['name' => 'Family Mourad','email' => 'mourad@family.com', 'wilaya' => 'Oran',        'commune' => 'Es Sénia',       'lat' => 35.6446, 'lng' => -0.6148],
            ['name' => 'Family Leila', 'email' => 'leila@family.com',  'wilaya' => 'Constantine', 'commune' => 'Constantine',    'lat' => 36.3650, 'lng' => 6.6147],
            ['name' => 'Family Omar',  'email' => 'omar@family.com',   'wilaya' => 'Algiers',     'commune' => 'Cheraga',        'lat' => 36.7657, 'lng' => 2.9556],
        ];

        foreach ($familyData as $data) {
            $user = User::factory()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'phone' => '06' . rand(10000000, 99999999),
            ]);
            $family = Family::create(['user_id' => $user->id]);
            // Create localization record so "Near Me" works
            Localization::create([
                'user_id' => $user->id,
                'wilaya' => $data['wilaya'],
                'commune' => $data['commune'],
                'latitude' => $data['lat'],
                'logitude' => $data['lng'],
            ]);
            $families[] = $family;
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
                $status = $statuses[array_rand($statuses)];
                $startDate = now()->addDays(rand(1, 30));
                $endDate = (clone $startDate)->addDays(rand(10, 30));
                $offreId = $offres[array_rand($offres)]->id;

                $req = Request::create([
                    'family_id' => $family->id,
                    'offre_id' => $offreId,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => $status,
                ]);

                if ($status === 'assigned') {
                    AssignmentService::create([
                        'family_id' => $family->id,
                        'offre_id' => $offreId,
                        'price' => rand(1500, 5000),
                        'assigned_at' => now(),
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'status' => 'active'
                    ]);
                }
            }
        }
    }
}

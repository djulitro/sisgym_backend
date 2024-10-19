<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            ['name' => 'Super Admin'],
            ['name' => 'Admin'],
            ['name' => 'Profesor'],
            ['name' => 'Alumno'],
        ];

        foreach ($userTypes as $userType) {
            UserType::create($userType);
        }
    }
}

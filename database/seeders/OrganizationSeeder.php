<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = new \App\Models\Organization();
        $organization->name = 'Organization Prueba';
        $organization->address = 'Organization Prueba mi casa';
        $organization->save();
    }
}

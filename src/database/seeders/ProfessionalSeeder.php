<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthcareProfessional;

class ProfessionalSeeder extends Seeder
{
    public function run(): void
    {
        
        HealthcareProfessional::factory()->count(10)->create();
    }
}

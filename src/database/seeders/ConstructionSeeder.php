<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Construction;

class ConstructionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Construction::create([
            // 'year' => 'R4',
            // 'number' => 'KA-111',
            // 'progress' => '$2y$10$.7JEKM6X7xsecN3liykPHOrsYGamOFesT6STD3YzldndXWg6N12XC',
            // 'role' => '20',
        ]);
    }
}

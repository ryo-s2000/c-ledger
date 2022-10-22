<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$.7JEKM6X7xsecN3liykPHOrsYGamOFesT6STD3YzldndXWg6N12XC', //B2DDKdvTmiEzdfE
            'role' => '20',
        ]);
    }
}

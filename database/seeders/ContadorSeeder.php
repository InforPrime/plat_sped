<?php

namespace Database\Seeders;

use App\Helpers\ArrayContadores;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ContadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contadores = ArrayContadores::getContadores();

        foreach ($contadores as $contador) {
            User::create([
                'name' => $contador,
                'email' => $contador,
                'password' => Hash::make('password'),
                'role' => 'contador',
            ]);
        }
    }
}

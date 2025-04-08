<?php

namespace Database\Seeders;

use App\Helpers\ArrayClientes;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = ArrayClientes::getClientes();

        foreach ($clientes as $cliente) {

            $contador = User::where('email', $cliente['contador'])
                ->where('role', 'contador')->first();

            if (!$contador) {
                $contador = User::create([
                    'name' => $cliente['contador'],
                    'email' => $cliente['contador'],
                    'password' => Hash::make('password'),
                    'role' => 'contador',
                ]);
            }

            Cliente::create([
                'nome' => $cliente['nome'],
                'contador_id' => $contador->id,
                'nome_modelo' => $cliente['nome_modelo'],
            ]);
        }
    }
}

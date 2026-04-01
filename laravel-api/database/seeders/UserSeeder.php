<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // gerar nomes e emails
            $faker = Faker::create();

            // Data de início (1 ano e 3 meses atrás)
            $startDate = Carbon::now()->subMonthsNoOverflow(15)->startOfMinute();

            // Data de fim (agora)
            $endDate = Carbon::now()->startOfMinute();

            // Número de usuários
            $totalUsers = 30;

            // Calcular o total de segundos entre as datas
            $totalSeconds = $endDate->timestamp - $startDate->timestamp;

            // Cadastrar usuários
            for ($i = 0; $i < $totalUsers; $i++) {
                // Distribuição progressiva (crescimento quadrático)
                $progress = 1 - pow(($totalUsers - 1 - $i) / ($totalUsers - 1), 2);
                //$progress = pow($i / ($totalUsers - 1), 2); // vai de 0 até 1 (quadraticamente)

                $secondsToAdd = (int) round($progress * $totalSeconds);

                // Criar A data progressiva crescente
                $createdAt = (clone $startDate)->addSeconds($secondsToAdd);

                User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => '123456A#', // password
                    // 'password' => bycrypt('123456A#'),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt
                ]);
            }

            Log::info('Dados de teste cadastrado na tabela users.');

        } catch (\Exception $e) {
            Log::notice('Dados de teste não cadastrado na tabela users.', ['error' => $e->getMessage()]);
        }
    }
}

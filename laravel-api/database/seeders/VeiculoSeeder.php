<?php

namespace Database\Seeders;

use App\Models\Veiculo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class VeiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {

            $veiculos = [
                ['model' => 'Gol', 'year' => 2010],
                ['model' => 'Corsa', 'year' => 2015],
                ['model' => 'Palio', 'year' => 2018],
                ['model' => 'Civic', 'year' => 2020],
                ['model' => 'Cruze', 'year' => 2022],
                ['model' => 'Onix', 'year' => 2019],
                ['model' => 'Corolla', 'year' => 2021],
                ['model' => 'Uno', 'year' => 2012],
                ['model' => 'Renegade', 'year' => 2023],
                ['model' => 'HB20', 'year' => 2017],
                ['model' => 'Ka', 'year' => 2014],
                ['model' => 'Fit', 'year' => 2016],
                ['model' => 'Compass', 'year' => 2022],
                ['model' => 'Sandero', 'year' => 2015],
                ['model' => 'Saveiro', 'year' => 2011],
            ];

            foreach ($veiculos as $veiculo) {
                $createdAt = Carbon::now()
                    ->subMonths(rand(0, 11))
                    ->setDay(rand(1, 31))
                    ->setTime(rand(0, 23), rand(0, 59), rand(0, 59));

                Veiculo::firstOrCreate(
                    [
                        'model' => $veiculo['model'],
                        'year' => $veiculo['year'],
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt
                    ],
                );
            }

            Log::info('Dados de teste cadastrado na tabela models.');
        } catch (\Exception $e) {
            Log::notice('Dados de teste não cadastrado na tabela models.', ['error' => $e->getMessage()]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaAtuacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['nome_area' => 'Médica'],
            ['nome_area' => 'Jurídica'],
            ['nome_area' => 'Psicologia'],
            ['nome_area' => 'Assistência Social'],
            // Adicione outras áreas conforme necessário para o Projeto Charis
        ];

        DB::table('areas_atuacao')->insert($areas);
    }
}

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
            ['nome_area' => 'Educação'],
            ['nome_area' => 'Enfermagem'],
            ['nome_area' => 'Fisioterapia'],
            ['nome_area' => 'Nutrição'],
            ['nome_area' => 'Terapia Ocupacional'],
            ['nome_area' => 'Odontologia'],
            ['nome_area' => 'Oftalmologia'],
        ];

        DB::table('areas_atuacao')->insert($areas);
    }
}

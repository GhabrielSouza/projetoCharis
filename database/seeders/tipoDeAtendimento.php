<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tipoDeAtendimento extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoDeAtendimentos = [
            ['nome' => 'Consulta Inicial'],
            ['nome' => 'Acompanhamento Regular'],
            ['nome' => 'Sessão de Terapia'],
            ['nome' => 'Avaliação Psicológica'],
            ['nome' => 'Orientação Profissional'],
            ['nome' => 'Terapia Ocupacional'],
            ['nome' => 'Reabilitação Cognitiva'],
            ['nome' => 'Terapia de Casal'],
            ['nome' => 'Terapia Familiar'],
            ['nome' => 'Intervenção em Crise'],
            ['nome' => 'Procediento médico'],
            ['nome' => 'Exame Laboratorial'],
            ['nome' => 'Sessão de Fisioterapia'],
            ['nome' => 'Consulta de Nutrição'],
            ['nome' => 'Acompanhamento Psicológico'],
            ['nome' => 'Orientação Jurídica'],
            ['nome' => 'Exame'],
            ['nome' => 'Consulta de Psicologia'],
            ['nome' => 'Retorno'],
        ];

        DB::table('tipo_de_atendimento')->insert($tipoDeAtendimentos);
    }
}

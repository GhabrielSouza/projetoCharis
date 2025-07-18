<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AreaAtucao extends Model
{
    use HasFactory;

    protected $table = 'areas_atuacao';

    protected $fillable = [
        'nome_area',
    ];

    // Relacionamento: Uma AreaAtuacao tem muitos Profissionais
    public function profissionais()
    {
        return $this->hasMany(Profissional::class);
    }

    // Relacionamento: Uma AreaAtuacao tem muitos Agendamentos
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    // Relacionamento: Uma AreaAtuacao tem muitos AtendimentosRealizados
    public function atendimentosRealizados()
    {
        return $this->hasMany(AtendimentoRealizado::class);
    }
}

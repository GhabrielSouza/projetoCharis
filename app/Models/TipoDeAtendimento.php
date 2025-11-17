<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDeAtendimento extends Model
{
    protected $table = 'tipo_de_atendimento';

    protected $fillable = [
        'nome',
    ];

    public function atendimentosRealizados()
    {
        return $this->hasMany(AtendimentoRealizado::class, 'tipo_de_atendimento_id', 'id');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'tipo_de_atendimento_id', 'id');
    }
}

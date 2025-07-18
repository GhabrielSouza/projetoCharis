<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AreaAtucao;

class Agendamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'beneficiario_id',
        'profissional_id',
        'area_atendimento_id',
        'data_hora_agendamento',
        'observacoes_agendamento',
        'status_agendamento',
    ];

    protected $dates = ['data_hora_agendamento']; // Para que o Eloquent trate como objeto Carbon

    // Relacionamento: Um Agendamento pertence a um Beneficiário
    public function beneficiario()
    {
        return $this->belongsTo(Beneficiario::class);
    }

    // Relacionamento: Um Agendamento pertence a um Profissional
    public function profissional()
    {
        return $this->belongsTo(Profissional::class);
    }

    // Relacionamento: Um Agendamento pertence a uma AreaAtuacao
    public function areaAtendimento()
    {
        return $this->belongsTo(AreaAtucao::class, 'area_atendimento_id');
    }

    // Relacionamento: Um Agendamento pode dar origem a um AtendimentoRealizado (um para um)
    public function atendimentoRealizado()
    {
        return $this->hasOne(AtendimentoRealizado::class, 'agendamento_origem_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AreaAtucao;

class AtendimentoRealizado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'atendimentos_realizados'; // Define o nome da tabela explicitamente

    protected $fillable = [
        'beneficiario_id',
        'profissional_id',
        'tipo_de_atendimento_id',
        'area_atendimento_id',
        'data_hora_atendimento',
        'descricao_atendimento',
        'hora_registro',
        'agendamento_origem_id',
    ];

    protected $dates = ['data_hora_atendimento']; // Para que o Eloquent trate como objeto Carbon

    // Relacionamento: Um AtendimentoRealizado pertence a um Beneficiário
    public function beneficiario()
    {
        return $this->belongsTo(Beneficiario::class);
    }

    // Relacionamento: Um AtendimentoRealizado pertence a um Profissional
    public function profissional()
    {
        return $this->belongsTo(Profissional::class);
    }

    // Relacionamento: Um AtendimentoRealizado pertence a uma AreaAtuacao
    public function areaAtendimento()
    {
        return $this->belongsTo(AreaAtucao::class, 'area_atendimento_id');
    }

    // Relacionamento: Um AtendimentoRealizado pode ter vindo de um Agendamento (um para um, opcional)
    public function agendamentoOrigem()
    {
        return $this->belongsTo(Agendamento::class, 'agendamento_origem_id');
    }

    public function tipoDeAtendimento()
    {
        return $this->belongsTo(TipoDeAtendimento::class, 'tipo_de_atendimento_id');
    }
}

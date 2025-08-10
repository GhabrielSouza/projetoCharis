<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AreaAtucao;

class Profissional extends Model
{
    use SoftDeletes;

    protected $table = 'profissionais';

    protected $fillable = [
        'nome_completo',
        'data_nascimento',
        'cpf',
        'telefone',
        'email',
        'numero_registro',
        'area_atuacao_id',
        'perfil',
        'observacoes',
        'status'
    ];


    protected $dates = ['data_nascimento']; // Para que o Eloquent trate como objeto Carbon

    // Relacionamento: Um Profissional pertence a uma AreaAtuacao
    public function areaAtuacao()
    {
        return $this->belongsTo(AreaAtucao::class);
    }

    // Relacionamento: Um Profissional tem muitos Agendamentos
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    // Relacionamento: Um Profissional tem muitos AtendimentosRealizados
    public function atendimentosRealizados()
    {
        return $this->hasMany(AtendimentoRealizado::class);
    }
}

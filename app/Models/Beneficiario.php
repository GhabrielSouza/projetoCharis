<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiario extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'sexo',
        'cpf',
        'telefone',
        'endereco_logradouro',
        'endereco_numero',
        'endereco_complemento',
        'endereco_bairro',
        'cidade_id',
        'cep',
        'escolaridade',
        'ocupacao',
        'cadunico',
        'limitacoes',
        'outras_limitacoes',
        'status',
        'observacoes'
    ];

    protected $casts = [
        'limitacoes' => 'array',
        'data_nascimento' => 'date'
    ];

    protected $dates = ['data_nascimento', 'data_cadastro'];

    // Relacionamento: Um Beneficiário pertence a uma Cidade
    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    // Relacionamento: Um Beneficiário tem muitos Agendamentos
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    // Relacionamento: Um Beneficiário tem muitos AtendimentosRealizados
    public function atendimentosRealizados()
    {
        return $this->hasMany(AtendimentoRealizado::class);
    }

    // Relacionamento: Um Beneficiário tem muitas CestasBasicasEntregues
    public function cestasBasicasEntregues()
    {
        return $this->hasMany(CestaBasicaEntregue::class);
    }
}

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
        'cpf',
        'telefone',
        'endereco_id',
        'escolaridade',
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

    public function endereco(): BelongsTo
    {
        return $this->belongsTo(Endereco::class);
    }

    // Método para acessar a cidade através do endereço
    public function cidade()
    {
        return $this->endereco?->cidade;
    }

    // Método para acessar o estado através do endereço->cidade
    public function estado()
    {
        return $this->endereco?->cidade?->estado;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Endereco extends Model
{
    protected $fillable = [
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cidade_id'
    ];

    public function cidade(): BelongsTo
    {
        return $this->belongsTo(Cidade::class);
    }

    public function beneficiario(): HasOne
    {
        return $this->hasOne(Beneficiario::class);
    }
}

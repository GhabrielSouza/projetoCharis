<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'area_atuacao',
        'perfil',
        'observacoes',
        'status'
    ];

}

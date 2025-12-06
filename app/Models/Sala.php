<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sala extends Model
{
    use SoftDeletes;

    protected $table = 'salas';
    protected $fillable = [
        'nome',
        'descricao',
        'profissional_id'
    ];

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id', 'id');
    }

    public function alunos()
    {
        return $this->belongsToMany(Beneficiario::class, 'sala_beneficiario', 'sala_id', 'beneficiario_id')
            ->withTimestamps();
    }
}

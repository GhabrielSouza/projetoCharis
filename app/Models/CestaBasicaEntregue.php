<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Beneficiario;

class CestaBasicaEntregue extends Model
{
    use HasFactory;

    protected $table = 'cestas_basicas_entregues';

    protected $fillable = [
        'beneficiario_id',
        'data_entrega',
        'quantidade',
        'observacoes',
    ];

    protected $dates = ['data_entrega'];

    // Relacionamento: Uma CestaBasicaEntregue pertence a um Beneficiário
    public function beneficiario()
    {
        return $this->belongsTo(Beneficiario::class);
    }
}

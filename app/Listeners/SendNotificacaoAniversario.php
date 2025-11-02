<?php

namespace App\Listeners;

use App\Events\NotificacaoAniversario;
use App\Models\Profissional;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notificacao;

class SendNotificacaoAniversario
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotificacaoAniversario $event): void
    {
        $profissional = $event->profissional;

        Notificacao::create([
            'tipo' => 'aniversario',
            'titulo' => 'Hoje é aniversário de ' . $profissional->nome_completo,
            'dados' => [
                'id_profissional' => $profissional->id,
                'nome' => $profissional->nome_completo,
                'data' => $profissional->data_nascimento,
            ],
            'user_id' => 1,
        ]);
    }
}

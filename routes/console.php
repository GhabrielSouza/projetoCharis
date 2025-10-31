<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Notificacao;
use App\Events\NotificacaoAniversario;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $notificacao = Notificacao::create([
        'tipo' => 'aniversario',
        'titulo' => '🎉 Verificando aniversariantes de hoje',
        'dados' => [],
        'id_pessoas_destinatario' => 1,
    ]);

    event(new NotificacaoAniversario($notificacao));
})->dailyAt('08:00');

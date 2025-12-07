<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Notificacao;
use App\Events\NotificacaoAniversario;
use App\Models\Profissional;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $profissionais = Profissional::whereMonth('data_nascimento', now()->month)
        ->whereDay('data_nascimento', now()->day)
        ->get();

    foreach ($profissionais as $profissional) {
        NotificacaoAniversario::dispatch($profissional);
    }
});

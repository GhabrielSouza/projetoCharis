<?php

use App\Http\Controllers\AgendamentoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\NotificacaoController;

Route::get('/', function () {
    return redirect('/login');
});

Route::any('/register', function () {
    abort(404);
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/beneficiarios', [App\Http\Controllers\BeneficiarioController::class, 'index'])->name('beneficiarios.index');
Route::post("/beneficiarios", [App\Http\Controllers\BeneficiarioController::class, 'store'])->name('beneficiarios.store');
Route::post('beneficiarios/{id}/toggle-status', [App\Http\Controllers\BeneficiarioController::class, 'toggleStatus'])->name('beneficiarios.toggleStatus');
Route::put('/beneficiarios/{id}', [BeneficiarioController::class, 'update'])->name('beneficiarios.update');
Route::delete('/beneficiarios/{id}', [App\Http\Controllers\BeneficiarioController::class, 'destroy'])->name('beneficiarios.destroy');
Route::get('/beneficiarios/search', [App\Http\Controllers\BeneficiarioController::class, 'search'])->name('beneficiarios.search');
Route::get('/beneficiarios/{beneficiario}/perfil', [App\Http\Controllers\BeneficiarioController::class, 'perfil'])->name('beneficiarios.perfil');

Route::get('/profissional', [App\Http\Controllers\ProfissionalController::class, 'index'])->name('profissionais.index');
Route::post("/profissional", [App\Http\Controllers\ProfissionalController::class, 'store'])->name('profissionais.store');
Route::post('profissional/{id}/toggle-status', [App\Http\Controllers\ProfissionalController::class, 'toggleStatus'])->name('profissional.toggleStatus');
Route::put("/profissional/{id}", [App\Http\Controllers\ProfissionalController::class, 'update'])->name('profissionais.update');
Route::get('/profissional/search', [App\Http\Controllers\ProfissionalController::class, 'search'])->name('profissionais.search');
Route::get('/profissional/{profissional}/perfil', [App\Http\Controllers\ProfissionalController::class, 'perfil'])->name('profissionais.perfil');


Route::get('/atendimentos', [App\Http\Controllers\AtendimentoController::class, 'index'])->name('atendimentos.index');
Route::post('/atendimentos', [App\Http\Controllers\AtendimentoController::class, 'store'])->name('atendimentos.store');
Route::get('/atendimentos/search', [App\Http\Controllers\AtendimentoController::class, 'search'])->name('atendimentos.search');
Route::put('/atendimentos/{id}', [App\Http\Controllers\AtendimentoController::class, 'update'])->name('atendimentos.update');
Route::delete('/atendimentos/{id}', [App\Http\Controllers\AtendimentoController::class, 'destroy'])->name('atendimentos.destroy');


Route::get('/agendamentos', [AgendamentoController::class, 'index'])->name('agendamento.index');
Route::post('/agendamentos', [AgendamentoController::class, 'store'])->name('agendamento.store');
Route::post('agendamentos/{id}/confirmar', [AgendamentoController::class, 'confirmar'])->name('agendamento.confirmar');
Route::patch('agendamentos/{id}/cancelar', [AgendamentoController::class, 'cancelar'])->name('agendamento.cancelar');
Route::get('agendamentos/{id}/prontuario', [AgendamentoController::class, 'gerarProntuario'])->name('agendamento.prontuario');

Route::get('/cestas', [App\Http\Controllers\CestaController::class, 'index'])->name('cestas.index');
Route::post('/cestas', [App\Http\Controllers\CestaController::class, 'store'])->name('cesta.store');
Route::put('/cestas/{id}', [App\Http\Controllers\CestaController::class, 'update'])->name('cesta.update');
Route::delete('/cestas/{id}', [App\Http\Controllers\CestaController::class, 'destroy'])->name('cesta.destroy');

Route::prefix('relatorios')->group(function () {
    Route::get('/atendimentos/periodo', [RelatorioController::class, 'atendimentosPorPeriodo'])->name('relatorios.atendimentos.periodo');
    Route::get('/atendimentos/beneficiario', [RelatorioController::class, 'atendimentosPorBeneficiario'])->name('relatorios.atendimentos.beneficiario');
    Route::get('/cestas', [RelatorioController::class, 'cestas'])->name('relatorios.cestas');
    Route::get('/anual', [RelatorioController::class, 'anual'])->name('relatorios.anual');
    Route::get('/agendamentos', [RelatorioController::class, 'agendamentos'])->name('relatorios.agendamentos');
});

Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');

Route::get('/notificacoes', [App\Http\Controllers\NotificacaoController::class, 'index'])->name('notificacoes.index');
Route::get('/notificacoes/json', [NotificacaoController::class, 'json'])->name('notificacoes.json');
Route::get('/notificacoes/{id}', [App\Http\Controllers\NotificacaoController::class, 'show'])->name('notificacoes.show');
Route::post('/notificacoes/{id}/marcar-como-lida', [App\Http\Controllers\NotificacaoController::class, 'marcarComoLida'])->name('notificacoes.marcarComoLida');
Route::post('/notificacoes/marcar-todas-como-lida', [App\Http\Controllers\NotificacaoController::class, 'marcarTodasComoLida'])->name('notificacoes.marcarTodasComoLida');

Route::resource('salas', App\Http\Controllers\SalasController::class);

Route::post('/salas/{id}/adicionar-alunos', [App\Http\Controllers\SalasController::class, 'storeStudents'])->name('salas.adicionarAlunos');
Route::delete('/salas/{sala_id}/remover-aluno/{beneficiario_id}', [App\Http\Controllers\SalasController::class, 'removeStudents'])->name('salas.removerAluno');

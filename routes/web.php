<?php

use App\Http\Controllers\Agendamento;
use App\Http\Controllers\AgendamentoController;
use App\Models\CestaBasicaEntregue;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;
use App\Http\Controllers\ProfissionalController;
use App\Http\Controllers\AtendimentoController;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

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


// Route::get('/relatorios', [App\Http\Controllers\RelatorioController::class, 'index'])->name('relatorios.index');

Route::get('/atendimentos', [App\Http\Controllers\AtendimentoController::class, 'index'])->name('atendimentos.index');
Route::post('/atendimentos', [App\Http\Controllers\AtendimentoController::class, 'store'])->name('atendimentos.store');
Route::get('/atendimentos/search', [App\Http\Controllers\AtendimentoController::class, 'search'])->name('atendimentos.search');
Route::put('/atendimentos/{id}', [App\Http\Controllers\AtendimentoController::class, 'update'])->name('atendimentos.update');
Route::delete('/atendimentos/{id}', [App\Http\Controllers\AtendimentoController::class, 'destroy'])->name('atendimentos.destroy');
Route::get('/atendimentos/{id}/relatorio', [App\Http\Controllers\AtendimentoController::class, 'relatorio'])->name('atendimentos.relatorio');
Route::get('/atendimentos/{id}/relatorio/pdf', [App\Http\Controllers\AtendimentoController::class, 'relatorioPdf'])->name('atendimentos.relatorio.pdf');
Route::get('/atendimentos/{id}/relatorio/print', [App\Http\Controllers\AtendimentoController::class, 'relatorioPrint'])->name('atendimentos.relatorio.print');
Route::get('/atendimentos/{id}/relatorio/print/pdf', [App\Http\Controllers\AtendimentoController::class, 'relatorioPrintPdf'])->name('atendimentos.relatorio.print.pdf');


Route::get('/agendamentos', [AgendamentoController::class, 'index'])->name('agendamento.index');
Route::post('/agendamentos', [AgendamentoController::class, 'store'])->name('agendamento.store');
Route::post('agendamentos/{id}/confirmar', [AgendamentoController::class, 'confirmar'])->name('agendamento.confirmar');
Route::patch('agendamentos/{id}/cancelar', [AgendamentoController::class, 'cancelar'])->name('agendamento.cancelar');


Route::get('/cestas', [App\Http\Controllers\CestaController::class, 'index'])->name('cestas.index');
Route::post('/cestas', [App\Http\Controllers\CestaController::class, 'store'])->name('cesta.store');
Route::put('/cestas/{id}', [App\Http\Controllers\CestaController::class, 'update'])->name('cesta.update');
Route::delete('/cestas/{id}', [App\Http\Controllers\CestaController::class, 'destroy'])->name('cesta.destroy');

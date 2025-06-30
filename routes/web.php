<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/beneficiario', [App\Http\Controllers\BeneficiarioController::class, 'index'])->name('cadastro.beneficiario');
Route::post("/beneficiario", [App\Http\Controllers\BeneficiarioController::class, 'store'])->name('beneficiarios.store');
Route::post('beneficiarios/{id}/toggle-status', [App\Http\Controllers\BeneficiarioController::class, 'toggleStatus'])->name('beneficiarios.toggleStatus');
Route::put('/beneficiarios/{id}', [BeneficiarioController::class, 'update'])->name('beneficiarios.update');
Route::get('/consulta/beneficiario', [App\Http\Controllers\BeneficiarioController::class, 'consulta'])->name('consulta.beneficiario');
Route::delete('/beneficiario/{id}', [App\Http\Controllers\BeneficiarioController::class, 'destroy'])->name('beneficiarios.destroy');


Route::get('/profissional', [App\Http\Controllers\ProfissionalController::class, 'index'])->name('cadastro.profissional');
Route::post("/profissional", [App\Http\Controllers\ProfissionalController::class, 'store'])->name('profissionais.store');

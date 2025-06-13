<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/beneficiario', [App\Http\Controllers\BeneficiarioController::class, 'index'])->name('cadastro.beneficiario');
Route::post("/beneficiario", [App\Http\Controllers\BeneficiarioController::class, 'store'])->name('beneficiarios.store');
Route::get('/consulta/beneficiario', [App\Http\Controllers\BeneficiarioController::class, 'consulta'])->name('consulta.beneficiario');

Route::get('/profissional', [App\Http\Controllers\ProfissionalController::class, 'index'])->name('cadastro.profissional');
Route::post("/profissional", [App\Http\Controllers\ProfissionalController::class, 'store'])->name('profissionais.store');

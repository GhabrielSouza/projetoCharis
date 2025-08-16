<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiarioController;

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

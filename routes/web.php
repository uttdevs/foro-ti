<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormularioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TallerController;

// Público
Route::get('/', fn () => view('spa'))->name('inicio');
Route::get('/agenda', fn () => view('spa'))->name('agenda');

Route::get('/registro', [FormularioController::class, 'index'])->name('registro');
Route::post('/registro-foro', [FormularioController::class, 'guardarForo'])->name('foro.guardar');

Route::get('/talleres', [TallerController::class, 'index'])->name('talleres');
Route::get('/talleres/datos', [TallerController::class, 'lista'])->name('talleres.datos');
Route::post('/talleres/inscribir', [TallerController::class, 'inscribir'])->name('talleres.inscribir');
// Login admin
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.post');

// Panel admin (protegido)
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/foro', [AdminController::class, 'foro'])->name('admin.foro');
    Route::get('/foro/pdf', [AdminController::class, 'foroPdf'])->name('admin.foro.pdf');
    Route::get('/foro/{asistente}/editar', [AdminController::class, 'foroEditar'])->name('admin.foro.edit');
    Route::put('/foro/{asistente}', [AdminController::class, 'foroActualizar'])->name('admin.foro.update');
    Route::delete('/foro/{asistente}', [AdminController::class, 'foroEliminar'])->name('admin.foro.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
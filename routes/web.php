<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/login-aluno", [SiteController::class, 'login']);
Route::get("/ver-curso", [SiteController::class, 'ver'])->name('ver');
Route::get("/ver-quiz", [SiteController::class, 'quiz'])->name('quiz');
Route::get("/info-aluno", [SiteController::class, 'info'])->name('info-aluno');
Route::get("/painel-aluno", [SiteController::class, 'painel'])->name('painel-aluno');

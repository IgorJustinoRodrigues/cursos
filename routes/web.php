<?php

use App\Http\Controllers\AdminController;
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

//Rota Diretório Raiz
Route::get('/', [SiteController::class, 'index'])->name('inicio');

//Rota Painel Admin Raiz
Route::get('/painel-admin', [AdminController::class, 'painel'])->name('painelAdmin');

/*
ROTAS DE ADMIN
*/
Route::get('/acesso-admin', [AdminController::class, 'acessoAdmin'])->name('acessoAdmin');

Route::get('/admin', [AdminController::class, 'index'])->name('adminIndex');
Route::get('/admin-cadastro', [AdminController::class, 'cadastro'])->name('adminCadastro');
Route::post('/admin-inserir', [AdminController::class, 'inserir'])->name('adminInserir');
Route::get('/admin-editar/{item}', [AdminController::class, 'editar'])->name('adminEditar');
Route::put('/admin-salvar/{item}', [AdminController::class, 'salvar'])->name('adminSalvar');
Route::delete('/admin-delete', [AdminController::class, 'deletar'])->name('adminDeletar');

/*
ROTAS DE LOGIN E LOGOFF
*/
Route::post('/login-admin', [AdminController::class, 'login'])->name('loginAdmin');
Route::get('/sair-admin', [AdminController::class, 'sair'])->name('sairAdmin');
Route::get('/recuperar-senha-admin', [AdminController::class, 'recuperar'])->name('recuperacaoAdmin');

Route::get("/login-aluno", [SiteController::class, 'login']);
Route::get("/ver-curso", [SiteController::class, 'ver'])->name('ver');
Route::get("/ver-quiz", [SiteController::class, 'quiz'])->name('quiz');
Route::get("/info-aluno", [SiteController::class, 'info'])->name('info-aluno');
Route::get("/painel-aluno", [SiteController::class, 'painel'])->name('painel-aluno');

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\ParceiroController;
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
Route::get('/admin', [AdminController::class, 'index'])->name('adminIndex');
Route::get('/admin-cadastro', [AdminController::class, 'cadastro'])->name('adminCadastro');
Route::post('/admin-inserir', [AdminController::class, 'inserir'])->name('adminInserir');
Route::get('/admin-editar/{item}', [AdminController::class, 'editar'])->name('adminEditar');
Route::put('/admin-salvar/{item}', [AdminController::class, 'salvar'])->name('adminSalvar');
Route::get('/admin-delete/{item}', [AdminController::class, 'deletar'])->name('adminDeletar');

/*
ROTAS DE LOGIN E LOGOFF
*/
Route::get('/acesso-admin', [AdminController::class, 'acessoAdmin'])->name('acessoAdmin');
Route::post('/login-admin', [AdminController::class, 'login'])->name('loginAdmin');
Route::get('/sair-admin', [AdminController::class, 'sair'])->name('sairAdmin');
Route::get('/recuperar-senha-admin', [AdminController::class, 'recuperacaoAdmin'])->name('recuperacaoAdmin');
Route::get('/verifica-email-admin', [AdminController::class, 'verificaEmailAdmin'])->name('verificaEmailAdmin');


//Rota Painel Aluno Raiz
Route::get('/painel-aluno', [AlunoController::class, 'painel'])->name('painelAluno');

/*
ROTAS DE ALUNO
*/
Route::get('/aluno', [AlunoController::class, 'index'])->name('alunoIndex');
Route::get('/aluno-cadastro', [AlunoController::class, 'cadastro'])->name('alunoCadastro');
Route::post('/aluno-inserir', [AlunoController::class, 'inserir'])->name('alunoInserir');
Route::get('/aluno-editar/{item}', [AlunoController::class, 'editar'])->name('alunoEditar');
Route::put('/aluno-salvar/{item}', [AlunoController::class, 'salvar'])->name('alunoSalvar');
Route::get('/aluno-delete/{item}', [AlunoController::class, 'deletar'])->name('alunoDeletar');


/*
ROTAS DE LOGIN E LOGOFF
*/
Route::get('/acesso-aluno', [AlunoController::class, 'acessoAluno'])->name('acessoAluno');
Route::post('/login-aluno', [AlunoController::class, 'login'])->name('loginAluno');
Route::get('/sair-aluno', [AlunoController::class, 'sair'])->name('sairAluno');
Route::get('/recuperar-senha-aluno', [AlunoController::class, 'recuperacaoAluno'])->name('recuperacaoAluno');
Route::get('/verifica-email-aluno', [AlunoController::class, 'verificaEmailAluno'])->name('verificaEmailAluno');


//Rota Painel Parceiro Raiz
Route::get('/painel-parceiro', [ParceiroController::class, 'painel'])->name('painelParceiro');

/*
ROTAS DE PARCEIRO
*/
Route::get('/parceiro', [ParceiroController::class, 'index'])->name('parceiroIndex');
Route::get('/parceiro-cadastro', [ParceiroController::class, 'cadastro'])->name('parceiroCadastro');
Route::post('/parceiro-inserir', [ParceiroController::class, 'inserir'])->name('parceiroInserir');
Route::get('/parceiro-editar/{item}', [ParceiroController::class, 'editar'])->name('parceiroEditar');
Route::put('/parceiro-salvar/{item}', [ParceiroController::class, 'salvar'])->name('parceiroSalvar');
Route::get('/parceiro-delete/{item}', [ParceiroController::class, 'deletar'])->name('parceiroDeletar');
Route::get('/parceiro-resete-senha/{item}', [ParceiroController::class, 'reseteSenha'])->name('parceiroReseteSenha');


/*
ROTAS DE LOGIN E LOGOFF
*/
Route::get('/acesso-parceiro', [ParceiroController::class, 'acessoParceiro'])->name('acessoParceiro');
Route::post('/login-parceiro', [ParceiroController::class, 'login'])->name('loginParceiro');
Route::get('/sair-parceiro', [ParceiroController::class, 'sair'])->name('sairParceiro');



Route::get("/login-aluno", [SiteController::class, 'login']);
Route::get("/ver-curso", [SiteController::class, 'ver'])->name('ver');
Route::get("/ver-quiz", [SiteController::class, 'quiz'])->name('quiz');
Route::get("/info-aluno", [SiteController::class, 'info'])->name('info-aluno');
Route::get("/painel-aluno", [SiteController::class, 'painel'])->name('painel-aluno');


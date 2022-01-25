<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\CategoriaCursoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\ParceiroController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\VendedorController;
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

/*
ROTAS DE SITE
*/
Route::post('/ativacao-codigo', [SiteController::class, 'ativacaoCodigo'])->name('site.ativacaoCodigo');
Route::post('/cancelar-ativacao-codigo', [SiteController::class, 'cancelarAtivacaoCodigo'])->name('site.cancelarAtivacao');
Route::post('/ativacao-escolha-curso', [SiteController::class, 'escolhaCurso'])->name('site.escolhaCurso');
Route::get('/confirmar-matricula', [AlunoController::class, 'confirmarMatricula'])->name('confirmarMatricula');
Route::post('/ativar-matricula', [AlunoController::class, 'ativarMatricula'])->name('ativar');
Route::get('/trocar-aluno-curso/{troca}', [AlunoController::class, 'trocarAlunoCurso'])->name('trocar');

Route::get('/como-ativar-codigo', [SiteController::class, 'comoAtivarCodigo'])->name('site.comoAtivarCodigo');
Route::get('/cursos/{categoria?}/{nome?}', [SiteController::class, 'cursos'])->name('site.cursos');
Route::get('/ler/curso/{item}/{url?}', [SiteController::class, 'lerCurso'])->name('site.lerCurso');
Route::get('/suporte', [SiteController::class, 'suporte'])->name('site.suporte');


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
Route::post('/admin-valida-usuario', [AdminController::class, 'validaUsuario'])->name('adminValidaUsuario');

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
Route::get('/minha-conta-aluno', [AlunoController::class, 'minhaConta'])->name('minhaConta');


/*
ROTAS DE ALUNO
*/
Route::get('/aluno', [AlunoController::class, 'index'])->name('alunoIndex');
Route::get('/aluno-cadastro', [AlunoController::class, 'cadastro'])->name('alunoCadastro');
Route::post('/aluno-inserir', [AlunoController::class, 'inserir'])->name('alunoInserir');
Route::get('/aluno-editar/{item}', [AlunoController::class, 'editar'])->name('alunoEditar');
Route::put('/aluno-salvar/{item}', [AlunoController::class, 'salvar'])->name('alunoSalvar');
Route::put('/aluno-salvar-minhas-informacoes', [AlunoController::class, 'salvarMinhasInformacoes'])->name('salvarMinhasInformacoes');
Route::get('/aluno-delete/{item}', [AlunoController::class, 'deletar'])->name('alunoDeletar');

Route::get("/ver-cursos", [AlunoController::class, 'verCursos'])->name('alunoCursos');
Route::get("/ver-aulas-curso/{curso}/{link?}", [CursoController::class, 'verAulas'])->name('verAulas');
Route::get("/aula/{id_curso}/{urlCurso}/{id_aula}/{titulo?}", [AlunoController::class, 'verAula'])->name('aula');
Route::post("/aula-concluir-aula", [AlunoController::class, 'concluirAula'])->name('concluirAula');

/*
ROTAS DE LOGIN E LOGOFF DE ALUNO
*/
Route::get('/acesso-aluno/{tela?}', [AlunoController::class, 'acessoAluno'])->name('acessoAluno');
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
ROTAS DE LOGIN E LOGOFF DE PARCEIRO
*/
Route::get('/acesso-parceiro', [ParceiroController::class, 'acessoParceiro'])->name('acessoParceiro');
Route::post('/login-parceiro', [ParceiroController::class, 'login'])->name('loginParceiro');
Route::get('/sair-parceiro', [ParceiroController::class, 'sair'])->name('sairParceiro');

/*
ROTAS DE PROFESSOR
*/
Route::get('/professor', [ProfessorController::class, 'index'])->name('professorIndex');
Route::get('/professor-cadastro', [ProfessorController::class, 'cadastro'])->name('professorCadastro');
Route::post('/professor-inserir', [ProfessorController::class, 'inserir'])->name('professorInserir');
Route::get('/professor-editar/{item}', [ProfessorController::class, 'editar'])->name('professorEditar');
Route::put('/professor-salvar/{item}', [ProfessorController::class, 'salvar'])->name('professorSalvar');
Route::get('/professor-delete/{item}', [ProfessorController::class, 'deletar'])->name('professorDeletar');

/*
ROTAS DE CURSO
*/
Route::get('/curso', [CursoController::class, 'index'])->name('cursoIndex');
Route::get('/curso-cadastro', [CursoController::class, 'cadastro'])->name('cursoCadastro');
Route::post('/curso-inserir', [CursoController::class, 'inserir'])->name('cursoInserir');
Route::get('/curso-editar/{item}/{menu?}', [CursoController::class, 'editar'])->name('cursoEditar');
Route::put('/curso-salvar/{item}', [CursoController::class, 'salvar'])->name('cursoSalvar');
Route::get('/curso-delete/{item}', [CursoController::class, 'deletar'])->name('cursoDeletar');

/*
ROTAS DE AULAS
*/
Route::get('/aula/{curso}', [AulaController::class, 'index'])->name('aulaIndex');
Route::get('/aula-cadastro/{curso}', [AulaController::class, 'cadastro'])->name('aulaCadastro');
Route::post('/aula-inserir/{curso}', [AulaController::class, 'inserir'])->name('aulaInserir');
Route::get('/aula-editar/{curso}/{item}', [AulaController::class, 'editar'])->name('aulaEditar');
Route::put('/aula-salvar/{curso}/{item}', [AulaController::class, 'salvar'])->name('aulaSalvar');
Route::get('/aula-delete/{curso}/{item}', [AulaController::class, 'deletar'])->name('aulaDeletar');
Route::post('/aula-reordenar/', [AulaController::class, 'ordenar'])->name('aulaOrdenar');
Route::post('/aula-inserir-anexo/', [AulaController::class, 'inserirAnexo'])->name('aulaInserirAnexo');
Route::post('/aula-listar-anexo/', [AulaController::class, 'listarAnexo'])->name('aulaListarAnexo');
Route::post('/aula-deletar-anexo/', [AulaController::class, 'deletarAnexo'])->name('aulaDeletarAnexo');

/*
ROTAS DE CATEGORIA DE CURSO
*/
Route::get('/categoria-curso', [CategoriaCursoController::class, 'index'])->name('categoriaCursoIndex');
Route::get('/categoria-curso-cadastro', [CategoriaCursoController::class, 'cadastro'])->name('categoriaCursoCadastro');
Route::post('/categoria-curso-inserir', [CategoriaCursoController::class, 'inserir'])->name('categoriaCursoInserir');
Route::get('/categoria-curso-editar/{item}', [CategoriaCursoController::class, 'editar'])->name('categoriaCursoEditar');
Route::put('/categoria-curso-salvar/{item}', [CategoriaCursoController::class, 'salvar'])->name('categoriaCursoSalvar');
Route::get('/categoria-curso-delete/{item}', [CategoriaCursoController::class, 'deletar'])->name('categoriaCursoDeletar');

/*
ROTAS DE UNIDADE
*/
Route::get('/unidade', [UnidadeController::class, 'index'])->name('unidadeIndex');
Route::get('/unidade-cadastro', [UnidadeController::class, 'cadastro'])->name('unidadeCadastro');
Route::post('/unidade-inserir', [UnidadeController::class, 'inserir'])->name('unidadeInserir');
Route::get('/unidade-editar/{item}', [UnidadeController::class, 'editar'])->name('unidadeEditar');
Route::put('/unidade-salvar/{item}', [UnidadeController::class, 'salvar'])->name('unidadeSalvar');
Route::get('/unidade-delete/{item}', [UnidadeController::class, 'deletar'])->name('unidadeDeletar');

/*
ROTAS DE MATRICULA
*/
Route::get('/matricula', [MatriculaController::class, 'index'])->name('matriculaIndex');
Route::get('/matricula-cadastro', [MatriculaController::class, 'cadastro'])->name('matriculaCadastro');
Route::post('/matricula-inserir', [MatriculaController::class, 'inserir'])->name('matriculaInserir');
Route::get('/matricula-editar/{item}', [MatriculaController::class, 'editar'])->name('matriculaEditar');
Route::put('/matricula-salvar/{item}', [MatriculaController::class, 'salvar'])->name('matriculaSalvar');
Route::get('/matricula-delete/{item}', [MatriculaController::class, 'deletar'])->name('matriculaDeletar');


//Rota Painel Vendedor Raiz
Route::get('/painel-vendedor', [VendedorController::class, 'painel'])->name('painelVendedor');
Route::get('/minha-conta-vendedor', [VendedorController::class, 'minhaContaVendedor'])->name('minhaContaVendedor');
/*
ROTAS DE VENDEDOR
*/
Route::get('/vendedor', [VendedorController::class, 'index'])->name('vendedorIndex');
Route::get('/vendedor-cadastro', [VendedorController::class, 'cadastro'])->name('vendedorCadastro');
Route::post('/vendedor-inserir', [VendedorController::class, 'inserir'])->name('vendedorInserir');
Route::get('/vendedor-editar/{item}', [VendedorController::class, 'editar'])->name('vendedorEditar');
Route::put('/vendedor-salvar/{item}', [VendedorController::class, 'salvar'])->name('vendedorSalvar');
Route::get('/vendedor-delete/{item}', [VendedorController::class, 'deletar'])->name('vendedorDeletar');

/*
ROTAS DE LOGIN E LOGOFF DE PARCEIRO
*/
Route::get('/acesso-vendedor', [VendedorController::class, 'acessoVendedor'])->name('acessoVendedor');
Route::post('/login-vendedor', [VendedorController::class, 'login'])->name('loginVendedor');
Route::get('/sair-vendedor', [VendedorController::class, 'sair'])->name('sairVendedor');

Route::get("/dlogin-aluno", [SiteController::class, 'login']);
Route::get("/dver-curso", [SiteController::class, 'ver'])->name('verd');
Route::get("/dver-quiz", [SiteController::class, 'quiz'])->name('quizd');
Route::get("/dinfo-aluno", [SiteController::class, 'info'])->name('info-alunod');
Route::get("/dpainel-aluno", [SiteController::class, 'painel'])->name('painel-alunod');

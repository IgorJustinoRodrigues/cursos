<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AjudaController;
use App\Http\Controllers\AlunoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\CategoriaAjudaController;
use App\Http\Controllers\CategoriaCursoController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ParceiroController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UnidadeController;
use App\Http\Controllers\VendedorController;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Artisan;
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


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});


//Rota Diretório Raiz
Route::get('/', [SiteController::class, 'index'])->name('inicio');
Route::get('/pdf', [CertificadoController::class, 'pdf']);

/*
ROTAS DE SITE
*/
Route::post('/ativacao-codigo', [SiteController::class, 'ativacaoCodigo'])->name('site.ativacaoCodigo');
Route::post('/cancelar-ativacao-codigo', [SiteController::class, 'cancelarAtivacaoCodigo'])->name('site.cancelarAtivacao');
Route::post('/ativacao-escolha-curso', [SiteController::class, 'escolhaCurso'])->name('site.escolhaCurso');
Route::get('/info-professor/{item}/{url?}', [SiteController::class, 'professor'])->name('site.Professor');
Route::get('/como-ativar-codigo', [SiteController::class, 'comoAtivarCodigo'])->name('site.comoAtivarCodigo');
Route::get('/cursos/{categoria?}/{nome?}', [SiteController::class, 'cursos'])->name('site.cursos');
Route::get('/conhecer/curso/{item}/{url?}', [SiteController::class, 'lerCurso'])->name('site.lerCurso');
Route::get('/aula-teste/{curso}/{url?}', [SiteController::class, 'aulaTeste'])->name('site.aulaTeste');
Route::get('/ajuda', [SiteController::class, 'ajuda'])->name('site.ajuda');
Route::get('/ajuda/{ajuda}/{url?}', [SiteController::class, 'verAjuda'])->name('site.verAjuda');
Route::get('/certificado', [SiteController::class, 'certificado'])->name('site.certificado');

/*
ROTAS DE CERTIFICADO
*/
Route::post('/solicitar-certificado/{url?}', [CertificadoController::class, 'solicitar'])->name('solicitarCertificado');
Route::post('/novo-certificado', [CertificadoController::class, 'novo'])->name('novoCertificado');

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
ROTAS DE LOGIN E LOGOFF ADMIN
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
Route::get('/aluno-delete/{item}', [AlunoController::class, 'deletar'])->name('alunoDeletar');

Route::put('/aluno-salvar-minhas-informacoes', [AlunoController::class, 'salvarMinhasInformacoes'])->name('salvarMinhasInformacoes');

/* 
ROTAS DA ABA DE AJUDA DE ALUNOS
*/
Route::get('/ajuda-professor-aluno', [AlunoController::class, 'ajudaProfessorAluno'])->name('contatoProfessor');
Route::get('/ajuda-aluno', [AlunoController::class, 'ajuda'])->name('aluno.ajuda');
Route::get('/ajuda-aluno/{ajuda}/{url?}', [AlunoController::class, 'verAjuda'])->name('aluno.verAjuda');

Route::get('/confirmar-matricula', [AlunoController::class, 'confirmarMatricula'])->name('confirmarMatricula');
Route::post('/ativar-matricula', [AlunoController::class, 'ativarMatricula'])->name('ativar');
Route::get('/trocar-aluno-curso/{troca}', [AlunoController::class, 'trocarAlunoCurso'])->name('trocar');

Route::get("/aulas-feitas", [AlunoController::class, 'aulasFeitas'])->name('aulasFeitas');
Route::get("/minhas-anotacoes", [AlunoController::class, 'minhasAnotacoes'])->name('minhasAnotacoes');
Route::get("/meus-cursos", [AlunoController::class, 'verCursos'])->name('alunoCursos');
Route::get("/ver-aulas-curso/{curso}/{link?}", [CursoController::class, 'verAulas'])->name('verAulas');
Route::get("/aula/{id_curso}/{urlCurso}/{id_aula}/{titulo?}", [AlunoController::class, 'verAula'])->name('aula');
Route::post("/aula-concluir-quiz", [AlunoController::class, 'concluirAulaQuiz'])->name('concluirAulaQuiz');
Route::post("/aula-concluir-aula", [AlunoController::class, 'concluirAula'])->name('concluirAula');
Route::post("/aula-avaliar", [AlunoController::class, 'avaliar'])->name('avaliar');
Route::post("/aula-anotacao", [AlunoController::class, 'anotacao'])->name('anotacao');

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
Route::get('/minha-conta-parceiro', [ParceiroController::class, 'minhaContaParceiro'])->name('minhaContaParceiro');

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
Route::post('/parceiro-valida-usuario', [ParceiroController::class, 'validaUsuarioParceiro'])->name('validaUsuarioParceiro');

Route::put('/parceiro-salvar-minhas-informacoes', [ParceiroController::class, 'salvarMinhasInformacoesParceiro'])->name('salvarMinhasInformacoesParceiro');

/* 
ROTAS DA ABA DE AJUDA DE PARCEIRO
*/
Route::get('/ajuda-parceiro', [ParceiroController::class, 'ajuda'])->name('parceiro.ajuda');
Route::get('/ajuda-parceiro/{ajuda}/{url?}', [ParceiroController::class, 'verAjuda'])->name('parceiro.verAjuda');

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
//Ajax
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

//Rota Painel Unidade Raiz
Route::get('/painel-unidade', [UnidadeController::class, 'painel'])->name('painelUnidade');
Route::get('/minha-conta-unidade', [UnidadeController::class, 'minhaContaUnidade'])->name('minhaContaUnidade');

/*
ROTAS DE UNIDADE
*/
Route::get('/unidade', [UnidadeController::class, 'index'])->name('unidadeIndex');
Route::get('/unidade-cadastro', [UnidadeController::class, 'cadastro'])->name('unidadeCadastro');
Route::post('/unidade-inserir', [UnidadeController::class, 'inserir'])->name('unidadeInserir');
Route::get('/unidade-editar/{item}', [UnidadeController::class, 'editar'])->name('unidadeEditar');
Route::put('/unidade-salvar/{item}', [UnidadeController::class, 'salvar'])->name('unidadeSalvar');
Route::get('/unidade-delete/{item}', [UnidadeController::class, 'deletar'])->name('unidadeDeletar');
Route::post('/unidade-valida-usuario', [UnidadeController::class, 'validaUsuarioUnidade'])->name('validaUsuarioUnidade');

Route::put('/unidade-salvar-minhas-informacoes', [UnidadeController::class, 'salvarMinhasInformacoesUnidade'])->name('salvarMinhasInformacoesUnidade');

/*
ROTAS DE CADASTRO DE UNIDADE EM PARCEIRO
*/
Route::get('/unidade-parceiro-index', [ParceiroController::class, 'indexUnidadeParceiro'])->name('indexUnidadeParceiro');
Route::get('/unidade-parceiro-cadastro', [ParceiroController::class, 'cadastroUnidadeParceiro'])->name('cadastroUnidadeParceiro');
Route::post('/unidade-parceiro-inserir', [UnidadeController::class, 'inserirUnidadeParceiro'])->name('inserirUnidadeParceiro');
Route::get('/unidade-parceiro-editar/{item}', [ParceiroController::class, 'editarUnidadeParceiro'])->name('editarUnidadeParceiro');
Route::put('/unidade-parceiro-salvar/{item}', [UnidadeController::class, 'salvarUnidadeParceiro'])->name('salvarUnidadeParceiro');
Route::get('/unidade-parceiro-delete/{item}', [UnidadeController::class, 'deletarUnidadeParceiro'])->name('deletarUnidadeParceiro');


/* 
ROTAS DE CADASTRO DE VENDEDOR EM UNIDADE
*/
Route::get('/vendedor-unidade-cadastro', [UnidadeController::class, 'cadastroVendedorUnidade'])->name('cadastroVendedorUnidade');
Route::post('/vendedor-unidade-inserir', [VendedorController::class, 'inserirVendedorUnidade'])->name('inserirVendedorUnidade');
Route::get('/vendedor-unidade-editar/{item}', [UnidadeController::class, 'editarVendedorUnidade'])->name('editarVendedorUnidade');
Route::put('/vendedor-unidade-salvar/{item}', [VendedorController::class, 'salvarVendedorUnidade'])->name('salvarVendedorUnidade');
Route::get('/vendedor-unidade-delete/{item}', [VendedorController::class, 'deletarVendedorUnidade'])->name('deletarVendedorUnidade');
Route::get('/vendedor-unidade-index', [UnidadeController::class, 'indexVendedorUnidade'])->name('indexVendedorUnidade');

/* 
ROTAS DE CADASTRO DE VENDEDOR EM PARCEIRO
*/
Route::get('/vendedor-parceiro-cadastro', [ParceiroController::class, 'cadastroVendedorParceiro'])->name('cadastroVendedorParceiro');
Route::post('/vendedor-parceiro-inserir', [VendedorController::class, 'inserirVendedorParceiro'])->name('inserirVendedorParceiro');
Route::get('/vendedor-parceiro-editar/{item}', [ParceiroController::class, 'editarVendedorParceiro'])->name('editarVendedorParceiro');
Route::put('/vendedor-parceiro-salvar/{item}', [VendedorController::class, 'salvarVendedorParceiro'])->name('salvarVendedorParceiro');
Route::get('/vendedor-parceiro-delete/{item}', [VendedorController::class, 'deletarVendedorParceiro'])->name('deletarVendedorParceiro');
Route::get('/vendedor-parceiro-index', [ParceiroController::class, 'indexVendedorParceiro'])->name('indexVendedorParceiro');

/* 
ROTAS DA ABA DE AJUDA DE UNIDADE
*/
Route::get('/ajuda-unidade', [UnidadeController::class, 'ajuda'])->name('unidade.ajuda');
Route::get('/ajuda-unidade/{ajuda}/{url?}', [UnidadeController::class, 'verAjuda'])->name('unidade.verAjuda');

/*
ROTAS DE LOGIN E LOGOFF DE UNIDADE
*/
Route::get('/acesso-unidade', [UnidadeController::class, 'acessoUnidade'])->name('acessoUnidade');
Route::post('/login-unidade', [UnidadeController::class, 'login'])->name('loginUnidade');
Route::get('/sair-unidade', [UnidadeController::class, 'sair'])->name('sairUnidade');

/*
ROTAS DE MATRICULA ADMIN
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
Route::post('/vendedor-valida-usuario', [VendedorController::class, 'validaUsuarioVendedor'])->name('validaUsuarioVendedor');

Route::put('/vendedor-salvar-minhas-informacoes', [VendedorController::class, 'salvarMinhasInformacoesVendedor'])->name('salvarMinhasInformacoesVendedor');


/* 
ROTAS DA ABA DE MATRÍCULA PAINEL VENDEDOR - ROTA DE CADASTRO E LISTAR DE MATRÍCULA EM VENDEDOR*/
Route::get('/ver-matricula-vendedor/{item}', [MatriculaController::class, 'verMatriculaVendedor'])->name('verMatriculaVendedor');

Route::get('/matricula-vendedor', [VendedorController::class, 'matriculaVendedorIndex'])->name('matriculaVendedorIndex');
Route::get('/matricula-cadastro-vendedor', [VendedorController::class, 'cadastroMatriculaVendedor'])->name('cadastroMatriculaVendedor');

Route::post('/listar-cursos-ajax/', [VendedorController::class, 'listarCursosAjax'])->name('listarCursosAjax');
/*ROTA DE INSERIR EM MATRÍCULACONTROLLER DE VENDEDOR*/
Route::post('/matricula-inserir-vendedor', [MatriculaController::class, 'inserirMatriculaVendedor'])->name('inserirMatriculaVendedor');

/* 
ROTAS DA ABA DE MATRÍCULA PAINEL UNiDADE - ROTA DE CADASTRO E LISTAR DE MATRÍCULA EM UNiDADE*/
Route::get('/ver-matricula-vendedor/{item}', [MatriculaController::class, 'verMatriculaVendedor'])->name('verMatriculaVendedor');


/* 
ROTAS DA ABA DE MATRÍCULA PAINEL UNIDADE - ROTA DE CADASTRO E LISTAR DE MATRÍCULA EM UNIDADE*/
Route::get('/ver-matricula-unidade/{item}', [MatriculaController::class, 'verMatriculaUnidade'])->name('verMatriculaUnidade');

Route::get('/matricula-unidade', [UnidadeController::class, 'matriculaUnidadeIndex'])->name('matriculaUnidadeIndex');
Route::get('/matricula-cadastro-unidade', [UnidadeController::class, 'cadastroMatriculaUnidade'])->name('cadastroMatriculaUnidade');

Route::post('/listar-cursos-ajax-unidade/', [UnidadeController::class, 'listarCursosUnidadeAjax'])->name('listarCursosUnidadeAjax');
/*ROTA DE INSERIR EM MATRÍCULACONTROLLER DE VENDEDOR*/
Route::post('/matricula-inserir-unidade', [MatriculaController::class, 'inserirMatriculaUnidade'])->name('inserirMatriculaUnidade');


//
/* 
ROTAS DA ABA DE MATRÍCULA PAINEL PARCEIRO - ROTA DE CADASTRO E LISTAR DE MATRÍCULA EM PARCEIRO*/
Route::get('/ver-matricula-parceiro/{item}', [MatriculaController::class, 'verMatriculaParceiro'])->name('verMatriculaParceiro');

Route::get('/matricula-parceiro', [ParceiroController::class, 'matriculaParceiroIndex'])->name('matriculaParceiroIndex');
Route::get('/matricula-cadastro-parceiro', [ParceiroController::class, 'cadastroMatriculaParceiro'])->name('cadastroMatriculaParceiro');

Route::post('/listar-cursos-ajax-parceiro/', [ParceiroController::class, 'listarCursosParceiroAjax'])->name('listarCursosParceiroAjax');
/*ROTA DE INSERIR EM MATRÍCULACONTROLLER DE VENDEDOR*/
Route::post('/matricula-inserir-parceiro', [MatriculaController::class, 'inserirMatriculaParceiro'])->name('inserirMatriculaParceiro');
//ROTA DE CANCELAMENTO DE MATRÍCULA 
Route::GET('/matricula-cancelar-parceiro/{id}', [MatriculaController::class, 'pedidoCancelarMatricula'])->name('pedidoCancelarMatricula');

//


/* 
ROTAS DA ABA DE AJUDA DE PAINEL VENDEDOR
*/
Route::get('/ajuda-vendedor', [VendedorController::class, 'ajuda'])->name('vendedor.ajuda');
Route::get('/ajuda-vendedor/{ajuda}/{url?}', [VendedorController::class, 'verAjuda'])->name('vendedor.verAjuda');

/*
ROTAS DE LOGIN E LOGOFF DE VENDEDOR
*/
Route::get('/acesso-vendedor', [VendedorController::class, 'acessoVendedor'])->name('acessoVendedor');
Route::post('/login-vendedor', [VendedorController::class, 'login'])->name('loginVendedor');
Route::get('/sair-vendedor', [VendedorController::class, 'sair'])->name('sairVendedor');


/*
ROTAS DE NEWSLETTER
*/
Route::post("/inscrever-newsletter", [NewsletterController::class, 'InserirNewsletter'])->name('InserirNewsletter');
Route::get('/newsletter-caixa-entrada', [NewsletterController::class, 'index'])->name('newsletterIndex');
Route::get('/newsletter-editar/{item}', [NewsletterController::class, 'editar'])->name('newsletterEditar');
Route::put('/newsletter-salvar/{item}', [NewsletterController::class, 'salvar'])->name('newsletterSalvar');
Route::get('/newsletter-delete/{item}', [NewsletterController::class, 'deletar'])->name('newsletterDeletar');

/*
ROTAS DE AJUDA 
*/
Route::get('/ajuda-listar', [AjudaController::class, 'index'])->name('ajudaIndex');
Route::get('/ajuda-cadastro', [AjudaController::class, 'cadastro'])->name('ajudaCadastro');
Route::post('/ajuda-inserir', [AjudaController::class, 'inserir'])->name('ajudaInserir');
Route::get('/ajuda-editar/{item}', [AjudaController::class, 'editar'])->name('ajudaEditar');
Route::put('/ajuda-salvar/{item}', [AjudaController::class, 'salvar'])->name('ajudaSalvar');
Route::get('/ajuda-delete/{item}', [AjudaController::class, 'deletar'])->name('ajudaDeletar');

/*
ROTAS DE CATEGORIA DE AJUDA 
*/
Route::get('/categoria-ajuda', [CategoriaAjudaController::class, 'index'])->name('categoriaAjudaIndex');
Route::get('/categoria-ajuda-cadastro', [CategoriaAjudaController::class, 'cadastro'])->name('categoriaAjudaCadastro');
Route::post('/categoria-ajuda-inserir', [CategoriaAjudaController::class, 'inserir'])->name('categoriaAjudaInserir');
Route::get('/categoria-ajuda-editar/{item}', [CategoriaAjudaController::class, 'editar'])->name('categoriaAjudaEditar');
Route::put('/categoria-ajuda-salvar/{item}', [CategoriaAjudaController::class, 'salvar'])->name('categoriaAjudaSalvar');
Route::get('/categoria-ajuda-delete/{item}', [CategoriaAjudaController::class, 'deletar'])->name('categoriaAjudaDeletar');

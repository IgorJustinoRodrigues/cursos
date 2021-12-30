<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CategoriaCurso;
use App\Services\Services;
use Illuminate\Http\Request;

class CategoriaCursoController extends Controller
{

    /*
    Função Index de CategoriaCurso
    - Responsável por mostrar a tela de listagem de categoriaCurso 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota login de Administrador, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = CategoriaCurso::orderby('nome', 'asc')->where('status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de categoria de Curso passando parametros para view
        return view('painelAdmin.categoriaCurso.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de CategoriaCurso
    - Responsável por mostrar a tela de cadastro de professor
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela de cadastro de professor
        return view('painelAdmin.categoriaCurso.cadastro');
    }

    /*
    Função Inserir de CategoriaCurso
    - Responsável por inserir as informações de um novo professor
    - $request: Recebe valores do novo professor
    */
    public function inserir(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required|max:100',
        ]);

        //Nova instância do Model CategoriaCurso
        $item = new CategoriaCurso();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->status = $request->status;


        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota categoriaCursoIndex, com mensagem de sucesso
            return redirect()->route('categoriaCursoIndex')->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Categoria de Curso
    - Responsável por mostrar a tela de edição de Categoria de Curso
    - $item: Recebe o Id do Categoria de Curso que deverá ser editado
    */
    public function editar(CategoriaCurso $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há alguma categoria de curso  selecionado
        if (@$item) {

            if ($item->status == 0) {
                return redirect()->route('categoriaCursoIndex')->with('atencao', 'Categoria de Curso excluido!');
            }

            //Exibe a tela de edição de categoria de curso passando parametros para view
            return view('painelAdmin.categoriaCurso.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota categoriaCursoIndex, com mensagem de erro
            return redirect()->route('categoriaCursoIndex')->with('erro', 'Categoria de Curso não encontrado!');
        }
    }

    /*
    Função Salvar de Categoria de Curso
    - Responsável por editar as informações de uma categoria de curso já cadastrado
    - $request: Recebe valores de uma categoria de curso
    - $item: Recebe uma objeto de Categoria de Curso vázio para edição
    */
    public function salvar(Request $request, CategoriaCurso $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoadmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
        ]);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->status = $request->status;


        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            //Redirecionamento para a rota categoriaCursoIndex, com mensagem de sucesso
            return redirect()->route('categoriaCursoIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Categoria de Curso
    - Responsável por excluir as informações de uma Categoria de Curso
    - $request: Recebe o Id do uma Categoria de Curso a ser excluido
    */
    public function deletar(CategoriaCurso $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoCategoriaCurso, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta Categoria de Curso informado
        if ($item->save()) {

            //Redirecionamento para a rota categoriaCursoIndex, com mensagem de sucesso
            return redirect()->route('categoriaCursoIndex')->with('sucesso', 'CategoriaCurso excluido!');
        } else {
            //Redirecionamento para a rota categoriaCursoIndex, com mensagem de erro
            return redirect()->route('categoriaCursoIndex')->with('erro', 'CategoriaCurso não excluido!');
        }
    }



    /*
    Função status de Categoria de Curso
    - Responsável por exibir o status do Categoria de Curso
    - $status: Recebe o Id do status do Categoria de Curso
    */
    public function status($status)
    {
        //Verifica o status do Categoria de Curso
        switch ($status) {
            case 1:
                //Retorna o status Ativo
                return 'Ativo';
                break;

            case 2:
                //Retorna o status Inativo
                return 'Inativo';
                break;

            case 0:
                //Retorna o status Excluido
                return 'Excluido';
                break;
        }
    }
}

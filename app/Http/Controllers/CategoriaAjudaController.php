<?php

namespace App\Http\Controllers;

use App\Models\CategoriaAjuda;
use App\Services\Services;
use Illuminate\Http\Request;

class CategoriaAjudaController extends Controller
{
    /*
    Função Index de CategoriaAjuda
    - Responsável por mostrar a tela de listagem de categoriaAjuda 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota login de Administrador, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = CategoriaAjuda::orderby('nome', 'asc')->where('status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de categoria de Ajuda passando parametros para view
        return view('painelAdmin.categoriaAjuda.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de CategoriaAjuda
    - Responsável por mostrar a tela de cadastro de professor
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela de cadastro de professor
        return view('painelAdmin.categoriaAjuda.cadastro');
    }

    /*
    Função Inserir de CategoriaAjuda
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

        //Nova instância do Model CategoriaAjuda
        $item = new CategoriaAjuda();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->icone = $request->icone;
        $item->status = $request->status;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota categoriaAjudaIndex, com mensagem de sucesso
            return redirect()->route('categoriaAjudaIndex')->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Categoria de Ajuda
    - Responsável por mostrar a tela de edição de Categoria de Ajuda
    - $item: Recebe o Id do Categoria de Ajuda que deverá ser editado
    */
    public function editar(CategoriaAjuda $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há alguma categoria de ajuda  selecionado
        if (@$item) {

            if ($item->status == 0) {
                return redirect()->route('categoriaAjudaIndex')->with('atencao', 'Categoria de Ajuda excluido!');
            }

            //Exibe a tela de edição de categoria de ajuda passando parametros para view
            return view('painelAdmin.categoriaAjuda.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota categoriaAjudaIndex, com mensagem de erro
            return redirect()->route('categoriaAjudaIndex')->with('erro', 'Categoria de Ajuda não encontrado!');
        }
    }

    /*
    Função Salvar de Categoria de Ajuda
    - Responsável por editar as informações de uma categoria de ajuda já cadastrado
    - $request: Recebe valores de uma categoria de ajuda
    - $item: Recebe uma objeto de Categoria de Ajuda vázio para edição
    */
    public function salvar(Request $request, CategoriaAjuda $item)
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
        $item->icone = $request->icone;
        $item->status = $request->status;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            //Redirecionamento para a rota categoriaAjudaIndex, com mensagem de sucesso
            return redirect()->route('categoriaAjudaIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Categoria de Ajuda
    - Responsável por excluir as informações de uma Categoria de Ajuda
    - $request: Recebe o Id do uma Categoria de Ajuda a ser excluido
    */
    public function deletar(CategoriaAjuda $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoCategoriaAjuda, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta Categoria de Ajuda informado
        if ($item->save()) {

            //Redirecionamento para a rota categoriaAjudaIndex, com mensagem de sucesso
            return redirect()->route('categoriaAjudaIndex')->with('sucesso', 'Categoria de ajuda excluido!');
        } else {
            //Redirecionamento para a rota categoriaAjudaIndex, com mensagem de erro
            return redirect()->route('categoriaAjudaIndex')->with('erro', 'Categoria de ajuda não excluido!');
        }
    }

    /*
    Função status de Categoria de Ajuda
    - Responsável por exibir o status do Categoria de Ajuda
    - $status: Recebe o Id do status do Categoria de Ajuda
    */
    public function status($status)
    {
        //Verifica o status do Categoria de Ajuda
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

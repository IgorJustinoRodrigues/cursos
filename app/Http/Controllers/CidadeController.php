<?php

namespace App\Http\Controllers;

use App\Models\Cidade;
use App\Services\Services;
use Illuminate\Http\Request;

class CidadeController extends Controller
{
    /*
    Função Index de Cidade
    - Responsável por mostrar a tela de listagem de cidades
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if(!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $items = Cidade::orderby('nome', 'asc')->where('nome', 'like', '%' . $request->busca . '%')->paginate();
        } else {
            //Paginação dos registros sem busca
            $items = Cidade::orderby('nome', 'asc')->paginate(5);
        }

        //Exibe a tela de listagem de cidades passando parametros para view
        return view('painelAdmin.cidade.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Cidade
    - Responsável por mostrar a tela de cadastro de cidades
    */
    public function cadastro()
    {
        //Validação de acesso
        if(!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela de cadastro de cidades
        return view('painelAdmin.cidade.cadastro');
    }

    /*
    Função Inserir de Cidade
    - Responsável por inserir as informações de um novo cidade
    - $request: Recebe valores do novo cidade
    */
    public function inserir(Request $request)
    {
        //Validação de acesso
        if(!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required|max:150|unique:cidades'
        ],[
            'nome.unique' => "O nome informado já existe no banco de dados!"
        ]);

        //Nova instância do Model Cidade
        $item = new Cidade();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota cidadeIndex, com mensagem de sucesso
            return redirect()->route('cidadeIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Cidade
    - Responsável por mostrar a tela de edição de cidades
    - $item: Recebe o Id do cidade que deverá ser editado
    */
    public function editar(Cidade $item)
    {
        //Validação de acesso
        if(!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há algum admim selecionado
        if (@$item) {

            //Exibe a tela de edição de cidades passando parametros para view
            return view('painelAdmin.cidade.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota cidadeIndex, com mensagem de erro
            return redirect()->route('cidadeIndex')->with('erro', 'Cidade não encontrada!');
        }
    }

    /*
    Função Salvar de Cidade
    - Responsável por editar as informações de um cidade já cadastrado
    - $request: Recebe valores de um cidade
    - $item: Recebe uma objeto de Cidade vázio para edição
    */
    public function salvar(Request $request, Cidade $item)
    {
        //Validação de acesso
        if(!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required|max:150|unique:cidades'
        ],[
            'nome.unique' => "O nome informado já existe no banco de dados!"
        ]);
        
        //Atribuição dos valores recebidos da váriavel $request para o objeto $item
        $item->nome = $request->nome;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {
            //Redirecionamento para a rota cidadeIndex, com mensagem de sucesso
            return redirect()->route('cidadeIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Cidade
    - Responsável por excluir as informações de um cidade
    - $request: Recebe o Id do um cidade a ser excluido
    */
    public function deletar(Request $request)
    {
        //Validação de acesso
        if(!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();
        //Realiza uma busca pelo Id
        $item = Cidade::find($request->id);

        //Deleta o cidade informado
        if ($item) {

            //Envio das informações para o banco de dados e verificação de sucesso
            if ($item->delete()) {
                //Redirecionamento para a rota cidadeIndex, com mensagem de sucesso
                return redirect()->route('cidadeIndex')->with('sucesso', 'Cidade excluido!');
            } else {
                //Redirecionamento para a rota cidadeIndex, com mensagem de sucesso
                return redirect()->route('cidadeIndex')->with('sucesso', 'Cidade excluido!');
            }
        } else {
            //Redirecionamento para a rota cidadeIndex, com mensagem de erro
            return redirect()->route('cidadeIndex')->with('erro', 'Cidade não excluido!');
        }
    }
}
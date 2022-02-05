<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Services\Services;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function InserirNewsletter(Request $request)
    {
        //Verifica se já existe o email enviado
        $verifica = Newsletter::where('email', '=', $request->email)->first();

        if ($verifica) {
            //Caso exista

            //Verifica o statos do registro
            if ($verifica->status == 1) {
                //Resposta que email já esta cadastrado
                $retorno = [
                    'msg' => 'O e-mail informado já está cadastrado!',
                    'status' => 2
                ];
            } else {
                //Caso onde o email existe porem está inativo

                //Verifica o nome enviado
                $validated = $request->validate([
                    'nome' => 'required'
                ]);

                //Atribui o nome enviado ao registro e o status com ativo
                $verifica->nome = $request->nome;
                $verifica->status = 1;

                //Salva
                $verifica->save();

                //Retorno de sucesso
                $retorno = [
                    'msg' => 'Sua Inscrição foi realizada com sucesso',
                    'status' => 1
                ];
            }
        } else {
            //Validação das informações recebidas
            $validated = $request->validate([
                'nome' => 'required',
                'email' => 'required|email|max:200'
            ]);

            //Recebe os dados Enviados do internauta. 
            $item = new Newsletter();

            $item->nome = $request->nome;
            $item->email = $request->email;
            //Hash da data com hora atual
            $item->hash = md5(date('dmYHis'));
            $item->status = 1;

            //Salva
            $resposta = $item->save();

            //Verifica se salvou
            if ($resposta) {
                //Resposta de sucesso
                $retorno = [
                    'msg' => 'Sua Inscrição foi realizada com sucesso',
                    'status' => 1
                ];
            } else {
                //Resposta de erro
                $retorno = [
                    'msg' => 'Não foi possível realizar a sua inscrição',
                    'status' => 0
                ];
            }
        }

        //Retorno json
        return response()->json($retorno);
    }

    /*
    Função Index de Newsletter
    - Responsável por mostrar a tela de listagem de categoriaAjuda 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota login de Administrador, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Newsletter::orderby('nome', 'asc')->where('status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de categoria de Ajuda passando parametros para view
        return view('painelAdmin.newsletter.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Editar de Newsletter
    - Responsável por mostrar a tela de edição de Newsletter
    - $item: Recebe o Id do Newsletter que deverá ser editado
    */
    public function editar(Newsletter $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há alguma newsletter  selecionado
        if (@$item) {

            //Exibe a tela de edição de newsletter passando parametros para view
            return view('painelAdmin.newsletter.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota newsletterIndex, com mensagem de erro
            return redirect()->route('newsletterIndex')->with('erro', 'Newsletter não encontrado!');
        }
    }

    /*
    Função Salvar de Newsletter
    - Responsável por editar as informações de uma newsletter já cadastrado
    - $request: Recebe valores de uma newsletter
    - $item: Recebe uma objeto de Newsletter vázio para edição
    */
    public function salvar(Request $request, Newsletter $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoadmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'email' => 'required|email|max:200'
        ]);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->email = $request->email;
        $item->status = $request->status;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            //Redirecionamento para a rota newsletterIndex, com mensagem de sucesso
            return redirect()->route('newsletterIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Newsletter
    - Responsável por excluir as informações de uma Newsletter
    - $request: Recebe o Id do uma Newsletter a ser excluido
    */
    public function deletar(Newsletter $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoCategoriaAjuda, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 2;

        //Deleta Newsletter informado
        if ($item->save()) {

            //Redirecionamento para a rota newsletterIndex, com mensagem de sucesso
            return redirect()->route('newsletterIndex')->with('sucesso', 'Newsletter Desativado!');
        } else {
            //Redirecionamento para a rota newsletterIndex, com mensagem de erro
            return redirect()->route('newsletterIndex')->with('erro', 'Newsletter não excluido!');
        }
    }
    /*
    Função Status de Newsletter
    - Responsável por exibir o Newsletter da Mensagem
    - $status: Recebe o Id do Newsletter da Mensagem
    */
    public function status($status)
    {
        //Verifica o status do Mensagem
        switch ($status) {
            case 1:
                //Retorna o status Mensagem
                return 'Ativo';
                break;

            case 2:
                //Retorna o status da Mensagem 
                return 'Inativo';
                break;
        }
    }
}

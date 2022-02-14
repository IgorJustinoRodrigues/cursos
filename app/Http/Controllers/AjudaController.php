<?php

namespace App\Http\Controllers;

use App\Models\Ajuda;
use App\Models\CategoriaAjuda;
use App\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AjudaController extends Controller
{
    /*
    Função Index de Ajuda
    - Responsável por mostrar a tela de listagem de ajuda 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota login de Administrador, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Ajuda::join('categoria_ajudas', 'ajudas.categoria_id', '=', 'categoria_ajudas.id')
            ->orderby('ajudas.nome', 'asc')->where('ajudas.status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('ajudas.nome', 'like', '%' . $request->busca . '%');

            if (Str::upper($request->busca) == 'SITE')
                $consulta->orWhere('ajudas.local', '=', '1');

            if (Str::upper($request->busca) == 'ALUNO')
                $consulta->orWhere('ajudas.local', '=', '2');

            if (Str::upper($request->busca) == 'VENDEDOR')
                $consulta->orWhere('ajudas.local', '=', '3');

            if (Str::upper($request->busca) == 'UNIDADE')
                $consulta->orWhere('ajudas.local', '=', '4');

            if (Str::upper($request->busca) == 'PARCEIRO')
                $consulta->orWhere('ajudas.local', '=', '5');

            $consulta->orWhere('categoria_ajudas.nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->selectRaw('ajudas.*, categoria_ajudas.nome as categoria')
            ->paginate();

        //Exibe a tela de listagem de Ajuda passando parametros para view
        return view('painelAdmin.ajuda.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Ajuda
    - Responsável por mostrar a tela de cadastro de professor
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $categorias = CategoriaAjuda::where('status', '=', 1)->get();

        if (count($categorias) < 1) {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->route('categoriaAjudaCadastro')->with('atencao', 'Para cadastrar uma nova tela de ajuda antes cadastre uma categoria');
        }

        //Exibe a tela de cadastro de professor
        return view('painelAdmin.ajuda.cadastro', ['categorias' => $categorias]);
    }

    /*
    Função Inserir de Ajuda
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
            'nome' => 'required|max:300',
            'texto' => 'required',
            'local' => 'required'
        ]);

        //Nova instância do Model Ajuda
        $item = new Ajuda();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->texto = html_entity_decode($request->texto);
        $item->local = $request->local;
        $item->categoria_id = $request->categoria_id;
        $item->status = $request->status;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota ajudaIndex, com mensagem de sucesso
            return redirect()->route('ajudaIndex')->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Ajuda
    - Responsável por mostrar a tela de edição de Ajuda
    - $item: Recebe o Id do Ajuda que deverá ser editado
    */
    public function editar(Ajuda $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há alguma ajuda  selecionado
        if (@$item) {

            if ($item->status == 0) {
                return redirect()->route('ajudaIndex')->with('atencao', 'Ajuda excluido!');
            }

            $categorias = CategoriaAjuda::where('status', '=', 1)->get();

            if (count($categorias) <= 0) {
                //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
                return redirect()->route('ajudaCadastro')->with('atencao', 'Para editar uma tela de ajuda antes cadastre uma categoria')->withInput();
            }

            //Exibe a tela de edição de ajuda passando parametros para view
            return view('painelAdmin.ajuda.editar', ['item' => $item, 'categorias' => $categorias]);
        } else {
            //Redirecionamento para a rota ajudaIndex, com mensagem de erro
            return redirect()->route('ajudaIndex')->with('erro', 'Ajuda não encontrado!');
        }
    }

    /*
    Função Salvar de Ajuda
    - Responsável por editar as informações de uma ajuda já cadastrado
    - $request: Recebe valores de uma ajuda
    - $item: Recebe uma objeto de Ajuda vázio para edição
    */
    public function salvar(Request $request, Ajuda $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoadmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required|max:300',
            'texto' => 'required',
            'local' => 'required'
        ]);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->texto = html_entity_decode($request->texto);
        $item->local = $request->local;
        $item->categoria_id = $request->categoria_id;
        $item->status = $request->status;

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            //Redirecionamento para a rota ajudaIndex, com mensagem de sucesso
            return redirect()->route('ajudaIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Ajuda
    - Responsável por excluir as informações de uma Ajuda
    - $request: Recebe o Id do uma Ajuda a ser excluido
    */
    public function deletar(Ajuda $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAjuda, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta Ajuda informado
        if ($item->save()) {

            //Redirecionamento para a rota ajudaIndex, com mensagem de sucesso
            return redirect()->route('ajudaIndex')->with('sucesso', 'Tela de ajuda excluida!');
        } else {
            //Redirecionamento para a rota ajudaIndex, com mensagem de erro
            return redirect()->route('ajudaIndex')->with('erro', 'Tela de ajuda não excluida!');
        }
    }

    /*
    Função status de Ajuda
    - Responsável por exibir o status do Ajuda
    - $status: Recebe o Id do status do Ajuda
    */
    public function status($status)
    {
        //Verifica o status do Ajuda
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

    /*
    Função local de Ajuda
    - Responsável por exibir o local da Ajuda
    - $local: Recebe o Id do local da Ajuda
    */
    public function local($local)
    {
        //Verifica o local do Ajuda
        switch ($local) {
            case 1:
                //Retorna o local Site
                return 'Site';
                break;

            case 2:
                //Retorna o local Aluno
                return 'Aluno';
                break;

            case 3:
                //Retorna o local Vendedor
                return 'Vendedor';
                break;

            case 4:
                //Retorna o local Unidade
                return 'Unidade';
                break;

            case 5:
                //Retorna o local Parceiro
                return 'Parceiro';
                break;
        }
    }
}

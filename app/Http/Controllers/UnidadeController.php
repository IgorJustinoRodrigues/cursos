<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Canvas;
use App\Models\Parceiro;
use App\Models\Unidade;
use App\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnidadeController extends Controller
{


    /*
    Função Index de Unidade
    - Responsável por mostrar a tela de listagem de unidade 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Unidade::join('parceiros', 'unidades.parceiro_id', '=', 'parceiros.id')
            ->orderby('parceiros.nome', 'asc')
            ->where('parceiros.status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('parceiros.nome', 'like', '%' . $request->busca . '%');
        }


        $items = $consulta->selectRaw('unidades.*, parceiros.nome as parceiro')
            ->paginate();

        //Exibe a tela de listagem de unidade passando parametros para view
        return view('painelAdmin.unidade.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Unidade
    - Responsável por mostrar a tela de cadastro de unidade
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $parceiro = Parceiro::where('status', '=', '1')->get();

        //Exibe a tela de cadastro de unidadeistradores
        return view('painelAdmin.unidade.cadastro', ['parceiro' => $parceiro]);
    }

    /*
    Função Inserir de Unidade
    - Responsável por inserir as informações de um novo unidade
    - $request: Recebe valores do novo unidade
    */
    public function inserir(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'usuario' => 'required|max:20|unique:unidades,usuario',
            'senha' => 'required'
        ]);

        //Nova instância do Model Unidade
        $item = new Unidade();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->usuario = $request->usuario;
        $item->senha = $request->senha;
        $item->email = $request->email;
        $item->whatsapp = $request->whatsapp;
        $item->contato = $request->contato;
        $item->endereco = $request->endereco;
        $item->cidade = $request->cidade;
        $item->estado = $request->estado;
        $item->facebook = $request->facebook;
        $item->instagram = $request->instagram;
        $item->site = $request->site;
        $item->parceiro_id = $request->parceiro_id;
        $item->status = $request->status;

        //Verificação se imagem de logo foi informado, caso seja verifica-se sua integridade
        if (@$request->file('logo') and $request->file('logo')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->logo = $request->logo->store('logoUnidade');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->logo))
                ->hexa('#FFFFFF')
                ->redimensiona(900, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->logo), 80);
        } else {
            //Atribuição de valor padrão para imagem logo caso o mesmo não seja informado 
            $item->logo = null;
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota unidadeIndex, com mensagem de sucesso
            return redirect()->route('unidadeIndex')->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Unidade
    - Responsável por mostrar a tela de edição de unidadeistradores
    - $item: Recebe o Id do unidade que deverá ser editado
    */
    public function editar($id)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $item = Unidade::join('parceiros', 'unidades.parceiro_id', '=', 'parceiros.id')
            ->orderby('parceiros.nome', 'asc')
            ->where('parceiros.status', '<>', '0')
            ->selectRaw('unidades.*, parceiros.nome as parceiro')
            ->find($id);

        //Verifica se há algum unidade selecionado
        if (@$item) {


            if ($item->status == 0) {
                return redirect()->route('unidadeIndex')->with('atencao', 'Unidade excluido!');
            }

            //Exibe a tela de edição de unidadeistradores passando parametros para view
            return view('painelAdmin.unidade.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota unidadeIndex, com mensagem de erro
            return redirect()->route('unidadeIndex')->with('erro', 'Unidade não encontrado!');
        }
    }

    /*
    Função Salvar de Unidade
    - Responsável por editar as informações de um unidadeistrador já cadastrado
    - $request: Recebe valores de um unidadeistrador
    - $item: Recebe uma objeto de Unidade vázio para edição
    */
    public function salvar(Request $request, Unidade $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'usuario' => "required|max:20|unique:unidades,usuario,{$item->id}",
            'nome' => 'required'
        ]);


        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->usuario = $request->usuario;
        
        //Verificação se uma nova senha foi informada
        if (@$request->senha != '') {
            //Validação das informações recebidas
            $validated = $request->validate([
                'senha' => 'required|min:6',
            ]);

            //Atribuição dos valores recebidos da váriavel $request para o objeto $item
            $item->senha = $request->senha;
        }

        $item->email = $request->email;
        $item->whatsapp = $request->whatsapp;
        $item->contato = $request->contato;
        $item->endereco = $request->endereco;
        $item->cidade = $request->cidade;
        $item->estado = $request->estado;
        $item->facebook = $request->facebook;
        $item->instagram = $request->instagram;
        $item->site = $request->site;
        $item->status = $request->status;


        //Verificação se uma nova imagem de logo foi informado, caso seja verifica-se sua integridade
        if (@$request->file('logo') and $request->file('logo')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Salva o nome da antiga imagem para ser apagada em caso de sucesso
            $logoApagar = $item->logo;
            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->logo = $request->logo->store('logoUnidade');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->logo))
                ->hexa('#FFFFFF')
                ->redimensiona(900, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->logo), 80);
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$logoApagar and Storage::exists($logoApagar)) {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($logoApagar);
            }

            //Redirecionamento para a rota unidadeIndex, com mensagem de sucesso
            return redirect()->route('unidadeIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Unidade
    - Responsável por excluir as informações de um unidade
    - $request: Recebe o Id do um unidade a ser excluido
    */
    public function deletar(Unidade $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta o unidadei informado
        if ($item->save()) {

            //Redirecionamento para a rota unidadeIndex, com mensagem de sucesso
            return redirect()->route('unidadeIndex')->with('sucesso', 'Unidade excluido!');
        } else {
            //Redirecionamento para a rota unidadeIndex, com mensagem de erro
            return redirect()->route('unidadeIndex')->with('erro', 'Unidade não excluido!');
        }
    }


    /*
    Função Resetar Senha de Unidade
    - Responsável por Resetar a senha de um unidade
    - $request: Recebe o Id do um unidade para a senha ser resetada
    */
    public function reseteSenha(Unidade $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->senha = '123456';

        //Deleta o unidadei informado
        if ($item->save()) {

            //Redirecionamento para a rota unidadeIndex, com mensagem de sucesso
            return redirect()->route('unidadeIndex')->with('sucesso', 'Senha resetada com sucesso!');
        } else {
            //Redirecionamento para a rota unidadeIndex, com mensagem de erro
            return redirect()->route('unidadeIndex')->with('erro', 'A senha não pode ser resetada!');
        }
    }


    /*
    Função Login de Unidade
    - Responsável pelo login do unidadeistrador ao painel
    - $request: Recebe as credênciais de acesso informadas pelo internauta
    */
    public function login(Request $request)
    {
        //Validação das informações recebidas
        $validated = $request->validate([
            'usuario' => 'required|max:20',
            'senha' => 'required'
        ]);

        //Atribuição dos valores recebidos da váriavel $request para o objeto $item
        $usuario = $request->usuario;
        $senha = $request->senha;

        //Seleciona o unidade no banco de dados, usando as credencias de acesso
        $item = Unidade::where('usuario', '=', $usuario)->where('senha', '=', $senha)->where('status', '=', 1)->first();

        //Verifica se existe um unidade com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {
            //Inícia a Sessão
            @session_start();

            //Obtem e preenche as informaçõs do unidade encontrado
            $logado['id_unidade'] = $item->id;
            $logado['nome_unidade'] = $item->nome;
            $logado['logo_unidade'] = $item->logo;
            $logado['usuario_unidade'] = $item->usuario;
            $logado['status_unidade'] = $item->status;
            $logado['visibilidade_unidade'] = $item->visibilidade;
            $logado['cadastro_unidade'] = $item->created_at->format('d/m/Y') . ' às ' . $item->created_at->format('H:i');
            $logado['ultimo_acesso_unidade'] = $item->updated_at->format('d/m/Y') . ' às ' . $item->updated_at->format('H:i');

            //Cria uma sessão com as informações
            $_SESSION['unidade_cursos_start'] = $logado;

            //Verifica se o campo lembrar senha estava selecionado
            if (@$request->remember) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('unidade_usuario', $request->usuario, 4320);
                Cookie::queue('unidade_senha', $request->senha, 4320);
            } else {
                //Expira os Cookies de credências
                Cookie::expire('unidade_usuario');
                Cookie::expire('unidade_senha');
            }

            //Atualiza a data e hora do campo updated_at
            $item->touch();

            //Redirecionamento para a rota painelUnidade, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelUnidade')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de unidade!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Sair de Unidade
    - Responsável pelo logoff do painel do unidade
    */
    public function sair()
    {
        //Inícia a Sessão
        @session_start();

        //Expira a sessão atual
        unset($_SESSION['unidade_cursos_start']);
        //Redirecionamento para a rota inicio, com mensagem de sucesso, sem uma sessão ativa
        return redirect()->route('acessoUnidade')->with('sucesso', 'Sessão encerrada com sucesso!');
    }

    /*
    Função status de Unidade
    - Responsável por exibir o status do unidade
    - $status: Recebe o Id do status do unidade
    */
    public function status($status)
    {
        //Verifica o status do unidade
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
    Função visibilidade de Unidade
    - Responsável por exibir o visibilidade do unidade
    - $visibilidade: Recebe o Id do visibilidade do unidade
    */
    public function visibilidade($visibilidade)
    {
        //Verifica o visibilidade do unidade
        switch ($visibilidade) {
            case 1:
                //Retorna o visibilidade Vísivel
                return 'Visível';
                break;

            case 2:
                //Retorna o visibilidade Não Vísivel
                return 'Não Visível';
                break;
        }
    }
}

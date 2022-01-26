<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Canvas;
use App\Models\Parceiro;
use App\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class ParceiroController extends Controller
{
    /*
    Função Acesso de Parceiro do Site
    - Responsável por mostrar a tela de login de Parceiro no site
    */
    public function acessoParceiro()
    {
        //Exibe a view
        return view('painelParceiro.parceiro.acessoParceiro');
    }


    /*
    Função Painel
    - Responsável por mostrar a tela inícial do painel de parceiroistradores
    */
    public function painel()
    {
        //Validação de acesso
        if (!(new Services())->validarParceiro())
            //Redirecionamento para a rota acessoParceiro, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarParceiro();

        //Exibe a tela inícial do painel de parceiroistradores passando parametros para view
        return view('painelParceiro.index');
    }

    /*
    Função Index de Parceiro
    - Responsável por mostrar a tela de listagem de parceiros 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoParceiro, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Parceiro::orderby('nome', 'asc')->where('status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de parceiroistradores passando parametros para view
        return view('painelAdmin.parceiro.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Parceiro
    - Responsável por mostrar a tela de cadastro de parceiroistradores
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoParceiro, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela de cadastro de parceiroistradores
        return view('painelAdmin.parceiro.cadastro');
    }

    /*
    Função Inserir de Parceiro
    - Responsável por inserir as informações de um novo parceiroistrador
    - $request: Recebe valores do novo parceiroistrador
    */
    public function inserir(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoParceiro, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'usuario' => 'required|max:20|unique:parceiros,usuario',
        ]);

        //Nova instância do Model Parceiro
        $item = new Parceiro();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->usuario = $request->usuario;
        $item->senha = '123456';
        $item->status = $request->status;
        $item->visibilidade = $request->visibilidade;
        $item->sobre = $request->sobre;

        //Verificação se imagem de logo foi informado, caso seja verifica-se sua integridade
        if (@$request->file('logo') and $request->file('logo')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->logo = $request->logo->store('logoParceiro');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->logo))
                ->hexa('#FFFFFF')
                ->redimensiona(159, 46, 'preenchimento')
                ->grava(public_path('storage/' . $item->logo), 80);
        } else {
            //Atribuição de valor padrão para imagem logo caso o mesmo não seja informado 
            $item->logo = null;
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota parceiroIndex, com mensagem de sucesso
            return redirect()->route('parceiroIndex')->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Parceiro
    - Responsável por mostrar a tela de edição de parceiroistradores
    - $item: Recebe o Id do parceiro que deverá ser editado
    */
    public function editar(Parceiro $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoParceiro, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há algum parceiro selecionado
        if (@$item) {

            if($item->status == 0){
                return redirect()->route('parceiroIndex')->with('atencao', 'Parceiro excluido!');
            }

            //Exibe a tela de edição de parceiroistradores passando parametros para view
            return view('painelAdmin.parceiro.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota parceiroIndex, com mensagem de erro
            return redirect()->route('parceiroIndex')->with('erro', 'Parceiro não encontrado!');
        }
    }

    /*
    Função Salvar de Parceiro
    - Responsável por editar as informações de um parceiroistrador já cadastrado
    - $request: Recebe valores de um parceiroistrador
    - $item: Recebe uma objeto de Parceiro vázio para edição
    */
    public function salvar(Request $request, Parceiro $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoParceiro, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'usuario' => "required|max:20|unique:parceiros,usuario,{$item->id}"
        ]);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->usuario = $request->usuario;
        $item->status = $request->status;
        $item->visibilidade = $request->visibilidade;
        $item->sobre = $request->sobre;


        //Verificação se uma nova imagem de logo foi informado, caso seja verifica-se sua integridade
        if (@$request->file('logo') and $request->file('logo')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Salva o nome da antiga imagem para ser apagada em caso de sucesso
            $logoApagar = $item->logo;
            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->logo = $request->logo->store('logoParceiro');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->logo))
                ->hexa('#FFFFFF')
                ->redimensiona(159, 46, 'preenchimento')
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

            //Redirecionamento para a rota parceiroIndex, com mensagem de sucesso
            return redirect()->route('parceiroIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Parceiro
    - Responsável por excluir as informações de um parceiro
    - $request: Recebe o Id do um parceiro a ser excluido
    */
    public function deletar(Parceiro $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoParceiro, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta o parceiroi informado
        if ($item->save()) {

            //Redirecionamento para a rota parceiroIndex, com mensagem de sucesso
            return redirect()->route('parceiroIndex')->with('sucesso', 'Parceiro excluido!');
        } else {
            //Redirecionamento para a rota parceiroIndex, com mensagem de erro
            return redirect()->route('parceiroIndex')->with('erro', 'Parceiro não excluido!');
        }
    }


    /*
    Função Resetar Senha de Parceiro
    - Responsável por Resetar a senha de um parceiro
    - $request: Recebe o Id do um parceiro para a senha ser resetada
    */
    public function reseteSenha(Parceiro $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoParceiro, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->senha = '123456';

        //Deleta o parceiroi informado
        if ($item->save()) {

            //Redirecionamento para a rota parceiroIndex, com mensagem de sucesso
            return redirect()->route('parceiroIndex')->with('sucesso', 'Senha resetada com sucesso!');
        } else {
            //Redirecionamento para a rota parceiroIndex, com mensagem de erro
            return redirect()->route('parceiroIndex')->with('erro', 'A senha não pode ser resetada!');
        }
    }


   /*
    Função Login de Parceiro
    - Responsável pelo login do parceiro ao painel
    - $request: Recebe as credênciais de acesso informadas pelo internauta
    */
    public function login(Request $request)
    {
        //Inícia a Sessão
        @session_start();


        //Validação das informações recebidas
        $validated = $request->validate([
            'usuario' => 'required',
            'senha' => 'required|min:6'
        ]);

        //Atribuição dos valores recebidos da váriavel $request para o objeto $item
        $usuario = $request->usuario;
        $senha = md5($request->senha);

        //Seleciona o parceiro no banco de dados, usando as credencias de acesso
        $item = Parceiro::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso_parceiro")->where('usuario', '=', $usuario)->where('senha', '=', $senha)->where('status', '=', 1)->first();



        //Verifica se existe um parceiro com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {

            //Cria uma sessão com as informações
            $_SESSION['parceiro_cursos_start'] = $item;


            //Verifica se o campo lembrar senha estava selecionado
            if (@$request->remember) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('parceiro_usuario', $request->usuario, 4320);
                Cookie::queue('parceiro_senha', $request->senha, 4320);
            } else {
                //Expira os Cookies de credências
                Cookie::expire('parceiro_usuario');
                Cookie::expire('parceiro_senha');
            }

            $item->touch();

            //Redirecionamento para a rota painelParceiro, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelParceiro')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de "' . $this->tipo($item->id) . '"');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->route('acessoParceiro')->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
                $request->except('senha')
            );
        }
    }

     /*
    Função Minha Conta de Parceiro
    - Responsável exibir a view de minha conta de parceiro painel do parceiro
    */
    public function minhaContaParceiro()
    {
        //Validação de acesso
        if (!(new Services())->validarParceiro())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarParceiro();

        $item = Parceiro::find($_SESSION['parceiro_cursos_start']->id);

        return view('painelParceiro.parceiro.minhaConta', [
            'item' => $item
        ]);
    }

    public function salvarMinhasInformacoesParceiro(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarParceiro())
            //Redirecionamento para a rota acessoParceiro, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarParceiro();

        //inicia sessão
        @session_start();

        $id = $_SESSION['parceiro_cursos_start']->id;

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
        ]);

        $item = Parceiro::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso_parceiro")
            ->find($id);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->sobre = $request->sobre;
        $item->usuario = $request->usuario;

        if (@$request->senha != '') {
            $validated = $request->validate([
                'senha' => 'required',
                'senha2' => 'required|same:senha'
            ]);

            //Atribuição dos valores recebidos da váriavel $request para o objeto $item
            $item->senha = MD5($request->senha);
        }

        //Verificação se uma nova imagem de logo foi informado, caso seja verifica-se sua integridade
        if (@$request->file('logo') and $request->file('logo')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Salva o nome da antiga imagem para ser apagada em caso de sucesso
            $logoApagar = $item->logo;
            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->logo = $request->logo->store('logoParceiro');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->logo))
                ->hexa('#FFFFFF')
                ->redimensiona(600, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->logo), 80);
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            $_SESSION['parceiro_cursos_start'] = $item;

            if ($request->hasCookie('parceiro_usuario') != false) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('parceiro_usuario', $request->usuario, 4320);
                Cookie::queue('parceiro_senha', $request->senha, 4320);
            }


            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$logoApagar and Storage::exists($logoApagar) and $logoApagar != 'logoParceiro/padrao.png') {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($logoApagar);
            }

            //Redirecionamento para a rota parceiroIndex, com mensagem de sucesso
            return redirect()->back()->with('sucesso', 'Edições salvas!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Algo deu errado, tente novamente!');
        }
    }


    /*
    Função Sair de Parceiro
    - Responsável pelo logoff do painel do parceiro
    */
    public function sair()
    {
        //Inícia a Sessão
        @session_start();

        //Expira a sessão atual
        unset($_SESSION['parceiro_cursos_start']);
        //Redirecionamento para a rota inicio, com mensagem de sucesso, sem uma sessão ativa
        return redirect()->route('acessoParceiro')->with('sucesso', 'Sessão encerrada com sucesso!');
    }

    /*
    Função status de Parceiro
    - Responsável por exibir o status do parceiro
    - $status: Recebe o Id do status do parceiro
    */
    public function status($status)
    {
        //Verifica o status do parceiro
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
    Função visibilidade de Parceiro
    - Responsável por exibir o visibilidade do parceiro
    - $visibilidade: Recebe o Id do visibilidade do parceiro
    */
    public function visibilidade($visibilidade)
    {
        //Verifica o visibilidade do parceiro
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

      /*
    Função Tipo de Admin
    - Responsável por exibir o tipo do parceiro
    - $tipo: Recebe o Id do tipo do parceiro
    */
    public function tipo($tipo)
    {
        //Verifica o tipo do parceiro
        switch ($tipo) {
            case 1:
                //Retorna o tipo Parceiro
                return 'Parceiro';
                break;
        }
    }
}

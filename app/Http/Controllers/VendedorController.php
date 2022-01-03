<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Canvas;
use App\Models\Unidade;
use App\Models\Vendedor;
use App\Services\Services;
use Illuminate\Http\Request;

class VendedorController extends Controller
{


    /*
    Função Index de Vendedor
    - Responsável por mostrar a tela de listagem de vendedor 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Vendedor::join('unidades', 'vendedors.unidade_id', '=', 'unidades.id')
            ->orderby('unidades.nome', 'asc')
            ->where('unidades.status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('vendedors.nome', 'like', '%' . $request->busca . '%');
        }


        $items = $consulta->selectRaw('vendedors.*, unidades.nome as unidade')
            ->paginate();

        //Exibe a tela de listagem de vendedor passando parametros para view
        return view('painelAdmin.vendedor.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Vendedor
    - Responsável por mostrar a tela de cadastro de vendedor
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $unidade = Unidade::where('status', '=', '1')->get();

        //Exibe a tela de cadastro de vendedor
        return view('painelAdmin.vendedor.cadastro', ['unidade' => $unidade]);
    }

    /*
    Função Inserir de Vendedor
    - Responsável por inserir as informações de um novo vendedor
    - $request: Recebe valores do novo vendedor
    */
    public function inserir(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'cpf' => 'required|max:11|unique:vendedors,cpf',
            'usuario' => 'required|max:20|unique:vendedors,usuario',
            'senha' => 'required'
        ]);

        //Nova instância do Model Vendedor
        $item = new Vendedor();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->cpf = $request->cpf;
        $item->email = $request->email;
        $item->whatsapp = $request->whatsapp;
        $item->usuario = $request->usuario;
        $item->senha = $request->senha;
        $item->status = $request->status;
        $item->unidade_id = $request->unidade_id;
        
        //Verificação se imagem de avatar foi informado, caso seja verifica-se sua integridade
        if (@$request->file('avatar') and $request->file('avatar')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->avatar = $request->avatar->store('avatarVendedor');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->avatar))
                ->hexa('#FFFFFF')
                ->redimensiona(900, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->avatar), 80);
        } else {
            //Atribuição de valor padrão para imagem avatar caso o mesmo não seja informado 
            $item->avatar = null;
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota vendedorIndex, com mensagem de sucesso
            return redirect()->route('vendedorIndex')->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Vendedor
    - Responsável por mostrar a tela de edição de vendedoristradores
    - $item: Recebe o Id do vendedor que deverá ser editado
    */
    public function editar($id)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $item = Vendedor::join('unidades', 'vendedors.unidade_id', '=', 'unidades.id')
            ->orderby('unidades.nome', 'asc')
            ->where('unidades.status', '<>', '0')
            ->selectRaw('vendedors.*, unidades.nome as unidade')
            ->find($id);

        //Verifica se há algum vendedor selecionado
        if (@$item) {


            if ($item->status == 0) {
                return redirect()->route('vendedorIndex')->with('atencao', 'Vendedor excluido!');
            }

            //Exibe a tela de edição de vendedoristradores passando parametros para view
            return view('painelAdmin.vendedor.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota vendedorIndex, com mensagem de erro
            return redirect()->route('vendedorIndex')->with('erro', 'Vendedor não encontrado!');
        }
    }

    /*
    Função Salvar de Vendedor
    - Responsável por editar as informações de um vendedoristrador já cadastrado
    - $request: Recebe valores de um vendedoristrador
    - $item: Recebe uma objeto de Vendedor vázio para edição
    */
    public function salvar(Request $request, Vendedor $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'usuario' => "required|max:20|unique:vendedors,usuario,{$item->id}",
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


        //Verificação se uma nova imagem de avatar foi informado, caso seja verifica-se sua integridade
        if (@$request->file('avatar') and $request->file('avatar')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Salva o nome da antiga imagem para ser apagada em caso de sucesso
            $avatarApagar = $item->avatar;
            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->avatar = $request->avatar->store('avatarVendedor');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->avatar))
                ->hexa('#FFFFFF')
                ->redimensiona(900, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->avatar), 80);
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$avatarApagar and Storage::exists($avatarApagar)) {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($avatarApagar);
            }

            //Redirecionamento para a rota vendedorIndex, com mensagem de sucesso
            return redirect()->route('vendedorIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Vendedor
    - Responsável por excluir as informações de um vendedor
    - $request: Recebe o Id do um vendedor a ser excluido
    */
    public function deletar(Vendedor $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta o vendedori informado
        if ($item->save()) {

            //Redirecionamento para a rota vendedorIndex, com mensagem de sucesso
            return redirect()->route('vendedorIndex')->with('sucesso', 'Vendedor excluido!');
        } else {
            //Redirecionamento para a rota vendedorIndex, com mensagem de erro
            return redirect()->route('vendedorIndex')->with('erro', 'Vendedor não excluido!');
        }
    }


    /*
    Função Resetar Senha de Vendedor
    - Responsável por Resetar a senha de um vendedor
    - $request: Recebe o Id do um vendedor para a senha ser resetada
    */
    public function reseteSenha(Vendedor $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->senha = '123456';

        //Deleta o vendedori informado
        if ($item->save()) {

            //Redirecionamento para a rota vendedorIndex, com mensagem de sucesso
            return redirect()->route('vendedorIndex')->with('sucesso', 'Senha resetada com sucesso!');
        } else {
            //Redirecionamento para a rota vendedorIndex, com mensagem de erro
            return redirect()->route('vendedorIndex')->with('erro', 'A senha não pode ser resetada!');
        }
    }


    /*
    Função Login de Vendedor
    - Responsável pelo login do vendedoristrador ao painel
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

        //Seleciona o vendedor no banco de dados, usando as credencias de acesso
        $item = Vendedor::where('usuario', '=', $usuario)->where('senha', '=', $senha)->where('status', '=', 1)->first();

        //Verifica se existe um vendedor com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {
            //Inícia a Sessão
            @session_start();

            //Obtem e preenche as informaçõs do vendedor encontrado
            $logado['id_vendedor'] = $item->id;
            $logado['nome_vendedor'] = $item->nome;
            $logado['avatar_vendedor'] = $item->avatar;
            $logado['usuario_vendedor'] = $item->usuario;
            $logado['status_vendedor'] = $item->status;
            $logado['visibilidade_vendedor'] = $item->visibilidade;
            $logado['cadastro_vendedor'] = $item->created_at->format('d/m/Y') . ' às ' . $item->created_at->format('H:i');
            $logado['ultimo_acesso_vendedor'] = $item->updated_at->format('d/m/Y') . ' às ' . $item->updated_at->format('H:i');

            //Cria uma sessão com as informações
            $_SESSION['vendedor_cursos_start'] = $logado;

            //Verifica se o campo lembrar senha estava selecionado
            if (@$request->remember) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('vendedor_usuario', $request->usuario, 4320);
                Cookie::queue('vendedor_senha', $request->senha, 4320);
            } else {
                //Expira os Cookies de credências
                Cookie::expire('vendedor_usuario');
                Cookie::expire('vendedor_senha');
            }

            //Atualiza a data e hora do campo updated_at
            $item->touch();

            //Redirecionamento para a rota painelVendedor, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelVendedor')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de vendedor!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Sair de Vendedor
    - Responsável pelo avatarff do painel do vendedor
    */
    public function sair()
    {
        //Inícia a Sessão
        @session_start();

        //Expira a sessão atual
        unset($_SESSION['vendedor_cursos_start']);
        //Redirecionamento para a rota inicio, com mensagem de sucesso, sem uma sessão ativa
        return redirect()->route('acessoVendedor')->with('sucesso', 'Sessão encerrada com sucesso!');
    }

    /*
    Função status de Vendedor
    - Responsável por exibir o status do vendedor
    - $status: Recebe o Id do status do vendedor
    */
    public function status($status)
    {
        //Verifica o status do vendedor
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
    Função visibilidade de Vendedor
    - Responsável por exibir o visibilidade do vendedor
    - $visibilidade: Recebe o Id do visibilidade do vendedor
    */
    public function visibilidade($visibilidade)
    {
        //Verifica o visibilidade do vendedor
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

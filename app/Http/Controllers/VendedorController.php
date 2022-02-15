<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ajuda;
use App\Models\Aluno;
use App\Models\Canvas;
use App\Models\CategoriaAjuda;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\Unidade;
use App\Models\Vendedor;
use App\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            ->where('vendedors.status', '<>', '0');

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
            'cpf' => 'required|max:14|unique:vendedors,cpf',
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
        $item->senha = md5($request->senha);
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
                ->redimensiona(550, 550, 'preenchimento')
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
            'cpf' => "required|max:14|unique:vendedors,cpf,{$item->id}",
            'usuario' => "required|max:20|unique:vendedors,usuario,{$item->id}",
        ]);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->cpf = $request->cpf;
        $item->email = $request->email;
        $item->whatsapp = $request->whatsapp;
        $item->usuario = $request->usuario;
        //Verificação se uma nova senha foi informada
        if (@$request->senha != '') {
            //Validação das informações recebidas
            $validated = $request->validate([
                'senha' => 'required|min:6',
            ]);

            //Atribuição dos valores recebidos da váriavel $request para o objeto $item
            $item->senha = md5($request->senha);
        }

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
                ->redimensiona(550, 550, 'preenchimento')
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


        $item->senha = md5('123456');

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
    Função Acesso de Vendedor do Site
    - Responsável por mostrar a tela de login de Vendedor no site
    */
    public function acessoVendedor()
    {
        //Exibe a view
        return view('painelVendedor.vendedor.acessoVendedor');
    }

    /*
    Função Login de Vendedor
    - Responsável pelo login do vendedoristrador ao painel
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

        //Seleciona o vendedor no banco de dados, usando as credencias de acesso
        $item = Vendedor::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso")->where('usuario', '=', $usuario)->where('senha', '=', $senha)->where('status', '=', 1)->first();



        //Verifica se existe um vendedor com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {

            //Cria uma sessão com as informações
            $_SESSION['vendedor_cursos_start'] = $item;


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

            $item->touch();

            //Redirecionamento para a rota painelVendedor, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelVendedor')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de "' . $this->tipo($item->id) . '"');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->route('acessoVendedor')->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Painel
    - Responsável por mostrar a tela inícial do painel de vendedor
    */
    public function painel()
    {
        //Validação de acesso
        if (!(new Services())->validarVendedor())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarVendedor();

        //Exibe a tela inícial do painel de vendedor passando parametros para view
        return view('painelVendedor.index');
    }


    public function minhaContaVendedor()
    {
        //Validação de acesso
        if (!(new Services())->validarVendedor())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarVendedor();

        $item = Vendedor::join('unidades', 'vendedors.unidade_id', '=', 'unidades.id')
            ->selectRaw("vendedors.*, unidades.nome as unidade")
            ->find($_SESSION['vendedor_cursos_start']->id);

        return view('painelVendedor.vendedor.minhaConta', [
            'item' => $item
        ]);
    }

    public function salvarMinhasInformacoesVendedor(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarVendedor())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarVendedor();

        //inicia sessão
        @session_start();

        $id = $_SESSION['vendedor_cursos_start']->id;

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
        ]);

        $item = Vendedor::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso")
            ->find($id);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->cpf = $request->cpf;
        $item->email = $request->email;
        $item->whatsapp = $request->whatsapp;
        $item->usuario = $request->usuario;

        if (@$request->senha != '') {
            $validated = $request->validate([
                'senha' => 'required',
                'senha2' => 'required|same:senha'
            ]);

            //Atribuição dos valores recebidos da váriavel $request para o objeto $item
            $item->senha = MD5($request->senha);
        }

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
                ->redimensiona(550, 550, 'preenchimento')
                ->grava(public_path('storage/' . $item->avatar), 80);
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            $_SESSION['vendedor_cursos_start'] = $item;

            if ($request->hasCookie('vendedor_usuario') != false) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('vendedor_usuario', $request->usuario, 4320);
                Cookie::queue('vendedor_senha', $request->senha, 4320);
            }


            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$avatarApagar and Storage::exists($avatarApagar) and $avatarApagar != 'avatarVendedor/padrao.png') {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($avatarApagar);
            }

            //Redirecionamento para a rota vendedorIndex, com mensagem de sucesso
            return redirect()->back()->with('sucesso', 'Edições salvas!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Algo deu errado, tente novamente!');
        }
    }

    //Função de Suporte
    public function ajuda()
    {

        $categoriasAjuda = CategoriaAjuda::join('ajudas', 'ajudas.categoria_id', '=', 'categoria_ajudas.id')
            ->where('ajudas.local', '=', 3)
            ->where('ajudas.status', '=', 1)
            ->where('categoria_ajudas.status', '=', 1)
            ->selectRaw('categoria_ajudas.*')
            ->groupBy('categoria_ajudas.id')
            ->get();

        for ($i = 0; $i < count($categoriasAjuda); $i++) {
            $categoriasAjuda[$i]->telas = Ajuda::where('categoria_id', '=', $categoriasAjuda[$i]->id)->where('local', '=', 3)->get();
        }

        //Exibe a view 
        return view('painelVendedor.ajuda.ajuda', [
            'categoriasAjuda' => $categoriasAjuda
        ]);
    }



    //Função de Suporte
    public function verAjuda($id, $url = '')
    {
        $ajuda = Ajuda::join('categoria_ajudas', 'ajudas.categoria_id', '=', 'categoria_ajudas.id')
            ->where('categoria_ajudas.status', '=', 1)
            ->where('ajudas.status', '=', 1)
            ->where('ajudas.local', '=', 3)
            ->where('ajudas.id', '=', $id)
            ->selectRaw('ajudas.*, categoria_ajudas.nome as categoria')
            ->first();

        if (!$ajuda) {
            return redirect()->route('aluno.ajuda')->with('atencao', 'Tela não encontrada!');
        }

        $categoriasAjuda = CategoriaAjuda::join('ajudas', 'ajudas.categoria_id', '=', 'categoria_ajudas.id')
            ->where('ajudas.local', '=', 3)
            ->where('ajudas.status', '=', 1)
            ->where('categoria_ajudas.status', '=', 1)
            ->selectRaw('categoria_ajudas.*')
            ->groupBy('categoria_ajudas.id')
            ->get();

        for ($i = 0; $i < count($categoriasAjuda); $i++) {
            $categoriasAjuda[$i]->telas = Ajuda::where('categoria_id', '=', $categoriasAjuda[$i]->id)->where('local', '=', 3)->get();

            if ($categoriasAjuda[$i]->id == $ajuda->categoria_id) {
                $telasAtual = $categoriasAjuda[$i]->telas;
            }
        }

        //Exibe a view 
        return view('painelVendedor.ajuda.verAjuda', [
            'ajuda' => $ajuda,
            'telasAtual' => $telasAtual,
            'categoriasAjuda' => $categoriasAjuda
        ]);
    }

    /*
    Função Cadastro de Matricula
    - Responsável por mostrar a tela de cadastro de professor
    */
    public function cadastroMatriculaVendedor()
    {
        //Validação de acesso
        if (!(new Services())->validarVendedor())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarVendedor();

        $alunos = Aluno::where('status', '=', 1)->get();
        $cursos = Curso::where('status', '=', 1)->get();

        //Exibe a tela de cadastro de professor
        return view('painelVendedor.matricula.cadastro', [
            'alunos' => $alunos,
            'cursos' => $cursos,
        ]);
    }

    /*
    Função Index de Matricula
    - Responsável por mostrar a tela de listagem de matricula 
    - $request: Recebe valores de busca e paginação
    */
    public function matriculaVendedorIndex(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarVendedor())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarVendedor();

        $consulta = Matricula::orderby('id', 'desc');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('ativacao', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de categoria de Curso passando parametros para view
        return view('painelVendedor.matricula.index', ['paginacao' => $items, 'busca' => @$request->busca]);
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
    Função Tipo de Admin
    - Responsável por exibir o tipo do vendedor
    - $tipo: Recebe o Id do tipo do vendedor
    */
    public function tipo($tipo)
    {
        //Verifica o tipo do vendedor
        switch ($tipo) {
            case 1:
                //Retorna o tipo Vendedor
                return 'Vendedor';
                break;
        }
    }


    /*
    Função Valida Usuário
    - Responsável por verificar se usuário de login já existe
    */
    public function validaUsuarioVendedor(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarVendedor())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarVendedor();

        //Atribuição dos valores

        $usuario = $request->usuario;
        $id = @$request->id;

        //Verificação do tamanho do usuário informado
        if (Str::length($usuario) >= 3) {

            //Consulta que busca se já existe um usuario no banco com o mesmo usuario
            $resultado = Vendedor::where('usuario', '=', $usuario)->first();

            //Verifica se existe
            if ($resultado) {
                //Verifica se o id informado é igual ao da consulta
                if ($resultado->id == $id) {
                    //Retorno de usuário atual 
                    $retorno = [
                        'msg' => 'Usuário atual!',
                        'tipo' => '3',
                        'status' => 1
                    ];
                } else {
                    //Retorno de usuário não disponível
                    $retorno = [
                        'msg' => 'Usuário "' . $usuario . '", não está disponível!',
                        'tipo' => '2',
                        'status' => 1
                    ];
                }
            } else {
                //Retorno do usuário disponível
                $retorno = [
                    'msg' => 'Usuário disponível!',
                    'tipo' => '1',
                    'status' => 1
                ];
            }
        } else {
            $retorno = [
                'msg' => 'O usuário deve ter no mínimo 3 caracteres!',
                'status' => 0
            ];
        }

        //Resposta JSON
        return response()->json($retorno);
    }



    public function listarCursosAjax(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarVendedor())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarVendedor();

            $tipo = @$request->tipo;
        
        $nivel = Curso::where('tipo', '=', $tipo)
            ->get();

            
        if ($nivel != null) {
            $retorno = [
                'status' => 1,
                'retorno' => $nivel
            ];
        } else {
            $retorno = [
                'msg' => 'Não há cursos para este nível!',
                'status' => 0
            ];
        }

        //Resposta JSON
        return response()->json($retorno);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ajuda;
use App\Models\Canvas;
use App\Models\CategoriaAjuda;
use App\Models\Parceiro;
use App\Models\Unidade;
use App\Models\Vendedor;
use App\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            ->orderby('unidades.nome', 'asc')
            ->where('unidades.status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('unidades.nome', 'like', '%' . $request->busca . '%');
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

        if (count($parceiro) <= 0) {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->route('parceiroCadastro')->with('atencao', 'Para cadastrar uma nova Unidade antes cadastre um Parceiro')->withInput();
        }

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
        $item->senha = md5($request->senha);
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
            ->orderby('unidades.nome', 'asc')
            ->where('unidades.status', '<>', '0')
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
            $item->senha = md5($request->senha);
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


        $item->senha = md5('123456');

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
    Função Acesso de Unidade do Site
    - Responsável por mostrar a tela de login de Unidade no site
    */
    public function acessoUnidade()
    {
        //Exibe a view
        return view('painelUnidade.unidade.acessoUnidade');
    }


    /*
    Função Login de Unidade
    - Responsável pelo login do unidade ao painel
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

        //Seleciona o unidade no banco de dados, usando as credencias de acesso
        $item = Unidade::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso_unidade")->where('usuario', '=', $usuario)->where('senha', '=', $senha)->where('status', '=', 1)->first();



        //Verifica se existe um unidade com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {

            //Cria uma sessão com as informações
            $_SESSION['unidade_cursos_start'] = $item;


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

            $item->touch();

            //Redirecionamento para a rota painelUnidade, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelUnidade')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de "' . $this->tipo($item->id) . '"');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->route('acessoUnidade')->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Painel
    - Responsável por mostrar a tela inícial do painel de parceiro
    */
    public function painel()
    {
        //Validação de acesso
        if (!(new Services())->validarUnidade())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarUnidade();

        //Exibe a tela inícial do painel de unidade passando parametros para view
        return view('painelUnidade.index');
    }

    /*
    Função Minha Conta de Unidade
    - Responsável exibir a view de minha conta de unidade painel do unidade
    */
    public function minhaContaUnidade()
    {
        //Validação de acesso
        if (!(new Services())->validarUnidade())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarUnidade();

        $item = Unidade::join('parceiros', 'unidades.parceiro_id', '=', 'parceiros.id')
            ->selectRaw("unidades.*, parceiros.nome as parceiro")
            ->find($_SESSION['unidade_cursos_start']->id);

        return view('painelUnidade.unidade.minhaConta', [
            'item' => $item
        ]);
    }

    public function salvarMinhasInformacoesUnidade(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarUnidade())
            //Redirecionamento para a rota acessoUnidade, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarUnidade();

        //inicia sessão
        @session_start();

        $id = $_SESSION['unidade_cursos_start']->id;

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
        ]);

        $item = Unidade::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso")
            ->find($id);

        //Atribuição dos valores recebidos da váriavel $request
        $item->email = $request->email;
        $item->whatsapp = $request->whatsapp;
        $item->contato = $request->contato;
        $item->endereco = $request->endereco;
        $item->cidade = $request->cidade;
        $item->estado = $request->estado;
        $item->facebook = $request->facebook;
        $item->instagram = $request->instagram;
        $item->site = $request->site;
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
            $item->logo = $request->logo->store('logoUnidade');

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

            $_SESSION['unidade_cursos_start'] = $item;

            if ($request->hasCookie('unidade_usuario') != false) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('unidade_usuario', $request->usuario, 4320);
                Cookie::queue('unidade_senha', $request->senha, 4320);
            }


            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$logoApagar and Storage::exists($logoApagar) and $logoApagar != 'logoUnidade/padrao.png') {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($logoApagar);
            }

            //Redirecionamento para a rota unidadeIndex, com mensagem de sucesso
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
            ->where('ajudas.local', '=', 4)
            ->where('ajudas.status', '=', 1)
            ->where('categoria_ajudas.status', '=', 1)
            ->selectRaw('categoria_ajudas.*')
            ->groupBy('categoria_ajudas.id')
            ->get();

        for ($i = 0; $i < count($categoriasAjuda); $i++) {
            $categoriasAjuda[$i]->telas = Ajuda::where('categoria_id', '=', $categoriasAjuda[$i]->id)->where('local', '=', 4)->get();
        }

        //Exibe a view 
        return view('painelUnidade.ajuda.ajuda', [
            'categoriasAjuda' => $categoriasAjuda
        ]);
    }



    //Função de Suporte
    public function verAjuda($id, $url = '')
    {
        $ajuda = Ajuda::join('categoria_ajudas', 'ajudas.categoria_id', '=', 'categoria_ajudas.id')
            ->where('categoria_ajudas.status', '=', 1)
            ->where('ajudas.status', '=', 1)
            ->where('ajudas.local', '=', 4)
            ->where('ajudas.id', '=', $id)
            ->selectRaw('ajudas.*, categoria_ajudas.nome as categoria')
            ->first();

        if (!$ajuda) {
            return redirect()->route('aluno.ajuda')->with('atencao', 'Tela não encontrada!');
        }

        $categoriasAjuda = CategoriaAjuda::join('ajudas', 'ajudas.categoria_id', '=', 'categoria_ajudas.id')
            ->where('ajudas.local', '=', 4)
            ->where('ajudas.status', '=', 1)
            ->where('categoria_ajudas.status', '=', 1)
            ->selectRaw('categoria_ajudas.*')
            ->groupBy('categoria_ajudas.id')
            ->get();

        for ($i = 0; $i < count($categoriasAjuda); $i++) {
            $categoriasAjuda[$i]->telas = Ajuda::where('categoria_id', '=', $categoriasAjuda[$i]->id)->where('local', '=', 4)->get();

            if ($categoriasAjuda[$i]->id == $ajuda->categoria_id) {
                $telasAtual = $categoriasAjuda[$i]->telas;
            }
        }

        //Exibe a view 
        return view('painelUnidade.ajuda.verAjuda', [
            'ajuda' => $ajuda,
            'telasAtual' => $telasAtual,
            'categoriasAjuda' => $categoriasAjuda
        ]);
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

    /*
    Função Valida Usuário
    - Responsável por verificar se usuário de login já existe
    */
    public function validaUsuarioUnidade(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarUnidade())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarUnidade();

        //Atribuição dos valores
        $tabela = $request->tabela;
        $usuario = $request->usuario;
        $id = @$request->id;

        //Verificação do tamanho do usuário informado
        if (Str::length($usuario) >= 3) {
            //Direcionamento para a tabela desejada
            switch ($tabela) {

                    //Caso de vendedor
                case 'vendedor':
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
                    break;

                    //Caso de unidade
                case 'unidade':
                    //Consulta que busca se já existe um usuario no banco com o mesmo usuario
                    $resultado = Unidade::where('usuario', '=', $usuario)->first();

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
                    break;

                default:
                    $retorno = [
                        'msg' => 'Paramêtros incorretos!',
                        'status' => 0
                    ];
                    break;
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

    /*
    Função Cadastro de Vendedor
    - Responsável por mostrar a tela de cadastro de vendedor
    */
    public function cadastroVendedorUnidade()
    {
        //Validação de acesso
        if (!(new Services())->validarUnidade())
            //Redirecionamento para a rota acessoVendedor, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarUnidade();

        $unidade = Unidade::where('status', '=', '1')->get();

        //Exibe a tela de cadastro de vendedor
        return view('painelUnidade.vendedor.cadastro', ['unidade' => $unidade]);
    }

    /*
    Função Index de Vendedor
    - Responsável por mostrar a tela de listagem de vendedor 
    - $request: Recebe valores de busca e paginação
    */
    public function indexVendedorUnidade(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarUnidade())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarUnidade();

        $consulta = Vendedor::join('unidades', 'vendedors.unidade_id', '=', 'unidades.id')
            ->where('vendedors.unidade_id', '=', $_SESSION['unidade_cursos_start']->id)
            ->where('vendedors.status', '<>', '0')
            ->orderby('unidades.nome', 'asc');


        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('vendedors.nome', 'like', '%' . $request->busca . '%');
        }


        $items = $consulta->selectRaw('vendedors.*, unidades.nome as unidade')
            ->paginate();

        //Exibe a tela de listagem de vendedor passando parametros para view
        return view('painelUnidade.vendedor.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Tipo de Admin
    - Responsável por exibir o tipo do unidade
    - $tipo: Recebe o Id do tipo do unidade
    */
    public function tipo($tipo)
    {
        //Verifica o tipo do unidade
        switch ($tipo) {
            case 1:
                //Retorna o tipo Unidade
                return 'Unidade';
                break;
        }
    }
}

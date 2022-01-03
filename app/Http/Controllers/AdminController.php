<?php
//Namespace do arquivo
namespace App\Http\Controllers;

//Dependências do controler
use App\Services\Services;
use App\Models\Admin;
use App\Models\Aluno;
use App\Models\Canvas;
use App\Models\Parceiro;
use App\Models\Servico;
use App\Models\Unidade;
use App\Models\Vendedor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

//Class AdminController
class AdminController extends Controller
{
    /*
    Função Acesso de Admin do Site
    - Responsável por mostrar a tela de login de Admin no site
    */
    public function acessoAdmin()
    {
        //Exibe a view
        return view('painelAdmin.admin.acessoAdmin');
    }

    /*
    Função Acesso de Admin do Site
    - Responsável por mostrar a tela de login de Admin no site
    */
    public function recuperacaoAdmin()
    {
        //Exibe a view
        return view('painelAdmin.admin.recuperaSenhaAdmin');
    }

    public function verificaEmailAdmin()
    {
        //Exibe a view
        dd('3');
    }

    /*
    Função Painel
    - Responsável por mostrar a tela inícial do painel de administradores
    */
    public function painel()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela inícial do painel de administradores passando parametros para view
        return view('painelAdmin.index');
    }

    /*
    Função Index de Admin
    - Responsável por mostrar a tela de listagem de administradores
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Admin::orderby('nome', 'asc');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de administradores passando parametros para view
        return view('painelAdmin.admin.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Admin
    - Responsável por mostrar a tela de cadastro de administradores
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela de cadastro de administradores
        return view('painelAdmin.admin.cadastro');
    }

    /*
    Função Inserir de Admin
    - Responsável por inserir as informações de um novo administrador
    - $request: Recebe valores do novo administrador
    */
    public function inserir(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'email' => 'required|max:100|unique:admins,email',
            'senha' => 'required|min:6',
        ]);

        //Nova instância do Model Admin
        $item = new Admin();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->email = $request->email;
        $item->senha = $request->senha;
        $item->tipo = $request->tipo;
        $item->anotacoes = $request->anotacoes;

        //Verificação se imagem de avatar foi informado, caso seja verifica-se sua integridade
        if (@$request->file('avatar') and $request->file('avatar')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->avatar = $request->avatar->store('avatarAdmin');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->avatar))
                ->hexa('#FFFFFF')
                ->redimensiona(600, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->avatar), 80);
        } else {
            //Atribuição de valor padrão para imagem avatar caso o mesmo não seja informado 
            $item->avatar = 'avatarAdmin/padrao.png';
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota adminIndex, com mensagem de sucesso
            return redirect()->route('adminIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Editar de Admin
    - Responsável por mostrar a tela de edição de administradores
    - $item: Recebe o Id do admin que deverá ser editado
    */
    public function editar(Admin $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há algum admim selecionado
        if (@$item) {

            //Exibe a tela de edição de administradores passando parametros para view
            return view('painelAdmin.admin.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota adminIndex, com mensagem de erro
            return redirect()->route('adminIndex')->with('erro', 'Administrador não encontrado!');
        }
    }

    /*
    Função Salvar de Admin
    - Responsável por editar as informações de um administrador já cadastrado
    - $request: Recebe valores de um administrador
    - $item: Recebe uma objeto de Admin vázio para edição
    */
    public function salvar(Request $request, Admin $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'email' => "required|max:100|unique:admins,email,{$item->id}"
        ]);

        //Atribuição dos valores recebidos da váriavel $request para o objeto $item
        $item->id = $request->id;
        $item->nome = $request->nome;
        $item->email = $request->email;
        $item->anotacoes = $request->anotacoes;

        //Verificação se uma nova senha foi informada
        if (@$request->senha != '') {
            //Validação das informações recebidas
            $validated = $request->validate([
                'senha' => 'required|min:6',
            ]);

            //Atribuição dos valores recebidos da váriavel $request para o objeto $item
            $item->senha = $request->senha;
        }

        //Verificação se o tipo do administrador foi informado
        if (@$request->tipo != '') {
            //Atribuição dos valores recebidos da váriavel $request para o objeto $item
            $item->tipo = $request->tipo;
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
            $item->avatar = $request->avatar->store('avatarAdmin');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->avatar))
                ->hexa('#FFFFFF')
                ->redimensiona(600, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->avatar), 80);
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verifica se o Update foi bem sucedido
        if ($resposta) {

            //Inícia a Sessão
            @session_start();

            //Verifica se o Id informado é o mesmo Id logado na sessão ativa
            if ($item->id == $_SESSION['admin_cursos_start']['id_admin']) {
                //Atribui os novos valores informados para a sessão ativa
                $logado['id_admin'] = $item->id;
                $logado['nome_admin'] = $item->nome;
                $logado['email_admin'] = $item->email;
                $logado['avatar_admin'] = $item->avatar;
                $logado['tipo_admin'] = $this->tipo($item->tipo);
                $logado['tipo_numero_admin'] = $item->tipo;
                $logado['anotacoes_admin'] = $item->anotacoes;
                $logado['cadastro_admin'] = $item->cadastro;
                $logado['ultimo_acesso_admin'] = $item->updated_at->format('d/m/Y') . ' às ' . $item->updated_at->format('H:i');

                //Substitui os valos da sessão ativa
                $_SESSION['admin_cursos_start'] = $logado;

                //Verifica se o campo Lembrar Senha estava ativo, através da existência de um email em Cookie
                if (Cookie::get('admin_email') != null) {

                    //Substitui os valores salvos em Cookie, válidos por 3 dias
                    Cookie::queue('admin_email', $item->email, 4320);
                    Cookie::queue('admin_senha', $item->senha, 4320);
                }
            }

            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$avatarApagar and Storage::exists($avatarApagar) and $avatarApagar != 'avatarAdmin/padrao.png') {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($avatarApagar);
            }

            //Redirecionamento para a rota adminIndex, com mensagem de sucesso
            return redirect()->route('adminIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Admin
    - Responsável por excluir as informações de um administrador
    - $request: Recebe o Id do um administrador a ser excluido
    */
    public function deletar(Admin $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Inícia a Sessão
        @session_start();

        //Verifica se o Id a ser excluido é igual ao Id da Sessão atual
        if ($item->id == $_SESSION['admin_cursos_start']['id_admin']) {
            //Redirecionamento para a rota adminIndex com mensagem de erro
            return redirect()->route('adminIndex')->with('erro', 'Você não pode excluir sua própria conta!');
        }

        //Deleta o admini informado
        if ($item->delete()) {
            //Verifica se há imagem para ser apagada e se caso exista, se é diferente do padrão
            if (Storage::exists($item->avatar) and $item->avatar != 'avatarAdmin/padrao.png') {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($item->avatar);
            }

            //Redirecionamento para a rota adminIndex, com mensagem de sucesso
            return redirect()->route('adminIndex')->with('sucesso', 'Administrador excluido!');
        } else {
            //Redirecionamento para a rota adminIndex, com mensagem de erro
            return redirect()->route('adminIndex')->with('erro', 'Administrador não excluido!');
        }
    }

    /*
    Função Login de Admin
    - Responsável pelo login do administrador ao painel
    - $request: Recebe as credênciais de acesso informadas pelo internauta
    */
    public function login(Request $request)
    {
        //Validação das informações recebidas
        $validated = $request->validate([
            'email' => 'required|max:200',
            'senha' => 'required'
        ]);

        //Atribuição dos valores recebidos da váriavel $request para o objeto $item
        $email = $request->email;
        $senha = $request->senha;

        //Seleciona o admin no banco de dados, usando as credencias de acesso
        $item = Admin::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso")->where('email', '=', $email)->where('senha', '=', $senha)->first();

        //Verifica se existe um admin com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {
            //Inícia a Sessão
            @session_start();

            //Obtem e preenche as informaçõs do admim encontrado
            $logado['id_admin'] = $item->id;
            $logado['nome_admin'] = $item->nome;
            $logado['email_admin'] = $item->email;
            $logado['avatar_admin'] = $item->avatar;
            $logado['tipo_admin'] = $this->tipo($item->tipo);
            $logado['tipo_numero_admin'] = $item->tipo;
            $logado['anotacoes_admin'] = $item->anotacoes;
            $logado['cadastro_admin'] = $item->cadastro;
            $logado['ultimo_acesso_admin'] = $item->ultimo_acesso;

            //Cria uma sessão com as informações
            $_SESSION['admin_cursos_start'] = $logado;

            //Verifica se o campo lembrar senha estava selecionado
            if (@$request->remember) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('admin_email', $request->email, 4320);
                Cookie::queue('admin_senha', $request->senha, 4320);
            } else {
                //Expira os Cookies de credências
                Cookie::expire('admin_email');
                Cookie::expire('admin_senha');
            }

            $item->touch();

            //Redirecionamento para a rota painelAdmin, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelAdmin')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de "' . $this->tipo($item->tipo) . '"');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Sair de Admin
    - Responsável pelo logoff do painel do administrador
    */
    public function sair()
    {
        //Inícia a Sessão
        @session_start();

        //Expira a sessão atual
        unset($_SESSION['admin_cursos_start']);
        //Redirecionamento para a rota inicio, com mensagem de sucesso, sem uma sessão ativa
        return redirect()->route('acessoAdmin')->with('sucesso', 'Sessão encerrada com sucesso!');
    }

    /*
    Função Tipo de Admin
    - Responsável por exibir o tipo do administrador
    - $tipo: Recebe o Id do tipo do administrador
    */
    public function tipo($tipo)
    {
        //Verifica o tipo do administrador
        switch ($tipo) {
            case 1:
                //Retorna o tipo Administração
                return 'Administração';
                break;

            case 2:
                //Retorna o tipo Atendimento
                return 'Atendimento';
                break;
        }
    }


    /*
    Função Valida Usuário
    - Responsável por verificar se usuário de login já existe
    */
    public function validaUsuario(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Atribuição dos valores
        $tabela = $request->tabela;
        $usuario = $request->usuario;
        $id = @$request->id;

        //Verificação do tamanho do usuário informado
        if (Str::length($usuario) >= 3) {
            //Direcionamento para a tabela desejada
            switch ($tabela) {
                    //Caso de parceiro
                case 'parceiro':
                    //Consulta que busca se já existe um usuario no banco com o mesmo usuario
                    $resultado = Parceiro::where('usuario', '=', $usuario)->first();

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


                    //Caso de aluno
                case 'aluno':
                    //Consulta que busca se já existe um usuario no banco com o mesmo usuario
                    $resultado = Aluno::where('usuario', '=', $usuario)->first();

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
                    //Caso Administrador
                case 'administrador':
                    $resultado = Admin::where('email', '=', $usuario)->first();

                    if ($resultado) {
                        if ($resultado->id == $id) {
                            $retorno = [
                                'msg' => 'E-mail atual!',
                                'tipo' => '3',
                                'status' => 1
                            ];
                        } else {
                            $retorno = [
                                'msg' => 'E-mail "' . $usuario . '", não está disponível!',
                                'tipo' => '2',
                                'status' => 1
                            ];
                        }
                    } else {
                        $retorno = [
                            'msg' => 'E-mail disponível!',
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
}

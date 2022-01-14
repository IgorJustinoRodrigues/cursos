<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Canvas;
use App\Models\Curso;
use App\Services\Services;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    /*
    Função Index de Aula
    - Responsável por mostrar a tela de listagem de aulas 
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request, Curso $curso)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Aula::orderby('nome', 'asc')->where('status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de aula passando parametros para view
        return view('painelAdmin.aula.index', ['curso' => $curso, 'paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Aula
    - Responsável por mostrar a tela de cadastro de aula
    */
    public function cadastro(Curso $curso)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela de cadastro de aula
        return view('painelAdmin.aula.cadastro', ['curso' => $curso]);
    }

    /*
    Função Inserir de Aula
    - Responsável por inserir as informações de um novo aulaistrador
    - $request: Recebe valores do novo aulaistrador
    */
    public function inserir(Request $request, Curso $curso)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'tipo' => 'required',
            'nome' => 'required',
            'duracao' => 'required',
            'status' => 'required',
        ]);
        
        //Nova instância do Model Aula
        $item = new Aula();

        switch ($request->tipo) {
            case 1:
                //Vídeo
                $validated = $request->validate([
                    'video' => 'required',
                ]);

                $item->avaliacao = 0;

                break;

            case 2:
                //Texto
                $validated = $request->validate([
                    'texto' => 'required',
                ]);

                $item->avaliacao = 0;

                break;

            case 3:
                //Quiz
                $validated = $request->validate([
                    'perguntas.*' => 'required',
                ]);

                $item->avaliacao = $request->avaliacao;
                
                break;

            default:
                //Erro
                break;
        }

        //Atribuição dos valores recebidos da váriavel $request
        $item->tipo = $request->tipo;
        $item->nome = $request->nome;
        $item->descricao = $request->descricao;
        $item->duracao_segundos = $request->duracao;
        $item->status = $request->status;
        $item->curso_id = $curso->id;
        
        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota aulaIndex, com mensagem de sucesso
            return redirect()->route('aulaIndex')->with('sucesso', '"' . $item->nome . '", inserido!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput();
        }
    }

    /*
    Função Editar de Aula
    - Responsável por mostrar a tela de edição de aula
    - $item: Recebe o Id do aula que deverá ser editado
    */
    public function editar(Curso $curso, Aula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há algum aula selecionado
        if (@$item) {

            if ($item->status == 0) {
                return redirect()->route('aulaIndex')->with('atencao', 'Aula excluido!');
            }

            //Exibe a tela de edição de aula passando parametros para view
            return view('painelAdmin.aula.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota aulaIndex, com mensagem de erro
            return redirect()->route('aulaIndex')->with('erro', 'Aula não encontrado!');
        }
    }

    /*
    Função Salvar de Aula
    - Responsável por editar as informações de um aulaistrador já cadastrado
    - $request: Recebe valores de um aulaistrador
    - $item: Recebe uma objeto de Aula vázio para edição
    */
    public function salvar(Request $request, Aula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'usuario' => "required|max:20|unique:aulas,usuario,{$item->id}"
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
            $item->logo = $request->logo->store('logoAula');

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

            //Redirecionamento para a rota aulaIndex, com mensagem de sucesso
            return redirect()->route('aulaIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Aula
    - Responsável por excluir as informações de um aula
    - $request: Recebe o Id do um aula a ser excluido
    */
    public function deletar(Aula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta o aulai informado
        if ($item->save()) {

            //Redirecionamento para a rota aulaIndex, com mensagem de sucesso
            return redirect()->route('aulaIndex')->with('sucesso', 'Aula excluido!');
        } else {
            //Redirecionamento para a rota aulaIndex, com mensagem de erro
            return redirect()->route('aulaIndex')->with('erro', 'Aula não excluido!');
        }
    }


    /*
    Função Resetar Senha de Aula
    - Responsável por Resetar a senha de um aula
    - $request: Recebe o Id do um aula para a senha ser resetada
    */
    public function reseteSenha(Aula $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAula, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->senha = '123456';

        //Deleta o aulai informado
        if ($item->save()) {

            //Redirecionamento para a rota aulaIndex, com mensagem de sucesso
            return redirect()->route('aulaIndex')->with('sucesso', 'Senha resetada com sucesso!');
        } else {
            //Redirecionamento para a rota aulaIndex, com mensagem de erro
            return redirect()->route('aulaIndex')->with('erro', 'A senha não pode ser resetada!');
        }
    }


    /*
    Função Login de Aula
    - Responsável pelo login do aulaistrador ao painel
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

        //Seleciona o aula no banco de dados, usando as credencias de acesso
        $item = Aula::where('usuario', '=', $usuario)->where('senha', '=', $senha)->where('status', '=', 1)->first();

        //Verifica se existe um aula com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {
            //Inícia a Sessão
            @session_start();

            //Obtem e preenche as informaçõs do aula encontrado
            $logado['id_aula'] = $item->id;
            $logado['nome_aula'] = $item->nome;
            $logado['logo_aula'] = $item->logo;
            $logado['usuario_aula'] = $item->usuario;
            $logado['status_aula'] = $item->status;
            $logado['visibilidade_aula'] = $item->visibilidade;
            $logado['cadastro_aula'] = $item->created_at->format('d/m/Y') . ' às ' . $item->created_at->format('H:i');
            $logado['ultimo_acesso_aula'] = $item->updated_at->format('d/m/Y') . ' às ' . $item->updated_at->format('H:i');

            //Cria uma sessão com as informações
            $_SESSION['aula_cursos_start'] = $logado;

            //Verifica se o campo lembrar senha estava selecionado
            if (@$request->remember) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('aula_usuario', $request->usuario, 4320);
                Cookie::queue('aula_senha', $request->senha, 4320);
            } else {
                //Expira os Cookies de credências
                Cookie::expire('aula_usuario');
                Cookie::expire('aula_senha');
            }

            //Atualiza a data e hora do campo updated_at
            $item->touch();

            //Redirecionamento para a rota painelAula, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelAula')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de aulas!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Sair de Aula
    - Responsável pelo logoff do painel do aula
    */
    public function sair()
    {
        //Inícia a Sessão
        @session_start();

        //Expira a sessão atual
        unset($_SESSION['aula_cursos_start']);
        //Redirecionamento para a rota inicio, com mensagem de sucesso, sem uma sessão ativa
        return redirect()->route('acessoAula')->with('sucesso', 'Sessão encerrada com sucesso!');
    }

    /*
    Função status de Aula
    - Responsável por exibir o status do aula
    - $status: Recebe o Id do status do aula
    */
    public function status($status)
    {
        //Verifica o status do aula
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
    Função visibilidade de Aula
    - Responsável por exibir o visibilidade do aula
    - $visibilidade: Recebe o Id do visibilidade do aula
    */
    public function visibilidade($visibilidade)
    {
        //Verifica o visibilidade do aula
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

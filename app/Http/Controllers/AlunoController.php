<?php
//Namespace do arquivo
namespace App\Http\Controllers;

//Dependências do controler
use App\Services\Services;
use App\Models\Aluno;
use App\Models\Canvas;
use App\Models\Servico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

//Class AlunoController
class AlunoController extends Controller
{
    /*
    Função Acesso de Aluno do Site
    - Responsável por mostrar a tela de login de Aluno no site
    */
    public function acessoAluno()
    {
        //Exibe a view
        return view('painelAluno.aluno.acessoAluno');
    }

    /*
    Função Acesso de Aluno do Site
    - Responsável por mostrar a tela de login de Aluno no site
    */
    public function recuperacaoAluno()
    {
        //Exibe a view
        return view('painelAluno.aluno.recuperaSenhaAluno');
    }

    public function verificaEmailAluno()
    {
        //Exibe a view
        dd('3');
    }

    /*
    Função Painel
    - Responsável por mostrar a tela inícial do painel de alunoistradores
    */
    public function painel()
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        //Exibe a tela inícial do painel de alunoistradores passando parametros para view
        return view('painelAluno.index');
    }

    /*
    Função Index de Aluno
    - Responsável por mostrar a tela de listagem de alunoistradores
    - $request: Recebe valores de busca e paginação
    */
    public function index(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        $consulta = Aluno::orderby('nome', 'asc')->where('status', '<>', '0');

        //Verifica se existe uma busca
        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->paginate();

        //Exibe a tela de listagem de alunoistradores passando parametros para view
        return view('painelAdmin.aluno.index', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    /*
    Função Cadastro de Aluno
    - Responsável por mostrar a tela de cadastro de alunoistradores
    */
    public function cadastro()
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Exibe a tela de cadastro de alunoistradores
        return view('painelAdmin.aluno.cadastro');
    }

    /*
    Função Inserir de Aluno
    - Responsável por inserir as informações de um novo alunoistrador
    - $request: Recebe valores do novo alunoistrador
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
            'usuario' => 'required|max:100|unique:alunos,email',
            'senha' => 'required|min:6',
            'pontuacao' => 'required'
        ]);

        //Nova instância do Model Aluno
        $item = new Aluno();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->nascimento = $request->nascimento;
        $item->sexo = $request->sexo;
        $item->cpf = $request->cpf;
        $item->rg = $request->rg;
        $item->nome_responsavel = $request->nome_responsavel;
        $item->cpf_responsavel = $request->cpf_responsavel;
        $item->rg_responsavel = $request->rg_responsavel;
        $item->email = $request->email;
        $item->whatsapp = $request->whatsapp;
        $item->telefone = $request->telefone;
        $item->contato = $request->contato;
        $item->endereco = $request->endereco;
        $item->cidade = $request->cidade;
        $item->estado = $request->estado;
        $item->usuario = $request->usuario;
        $item->senha = $request->senha;
        //pontuação resolver ainda...
        $item->pontuacao = $request->pontuacao;

        $item->status = $request->status;

        //Verificação se imagem de avatar foi informado, caso seja verifica-se sua integridade
        if (@$request->file('avatar') and $request->file('avatar')->isValid()) {
            //Validação das informações recebidas
            $validated = $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
            ]);

            //Atribuição dos valores recebidos da váriavel $request após seu upload
            $item->avatar = $request->avatar->store('avatarAluno');

            //Nova instância do Model Canvas
            $img = new Canvas();

            //Edição da imagem recebida com a Class Canva 
            $img->carrega(public_path('storage/' . $item->avatar))
                ->hexa('#FFFFFF')
                ->redimensiona(600, 600, 'preenchimento')
                ->grava(public_path('storage/' . $item->avatar), 80);
        } else {
            //Atribuição de valor padrão para imagem avatar caso o mesmo não seja informado 
            $item->avatar = 'avatarAluno/padrao.png';
        }

        //Envio das informações para o banco de dados
        $resposta = $item->save();

        //Verificação do insert
        if ($resposta) {
            //Redirecionamento para a rota alunoIndex, com mensagem de sucesso
            return redirect()->route('alunoIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {

            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Editar de Aluno
    - Responsável por mostrar a tela de edição de alunoistradores
    - $item: Recebe o Id do aluno que deverá ser editado
    */
    public function editar(Aluno $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Verifica se há algum admim selecionado
        if (@$item) {

            //Exibe a tela de edição de alunoistradores passando parametros para view
            return view('painelAdmin.aluno.editar', ['item' => $item]);
        } else {
            //Redirecionamento para a rota alunoIndex, com mensagem de erro
            return redirect()->route('alunoIndex')->with('erro', 'Aluno não encontrado!');
        }
    }

    /*
    Função Salvar de Aluno
    - Responsável por editar as informações de um alunoistrador já cadastrado
    - $request: Recebe valores de um alunoistrador
    - $item: Recebe uma objeto de Aluno vázio para edição
    */
    public function salvar(Request $request, Aluno $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'usuario' => 'required|max:100|unique:alunos,email',
            'pontuacao' => 'required'
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

        $item->nascimento = $request->nascimento;
        $item->sexo = $request->sexo;
        $item->cpf = $request->cpf;
        $item->rg = $request->rg;
        $item->nome_responsavel = $request->nome_responsavel;
        $item->cpf_responsavel = $request->cpf_responsavel;
        $item->rg_responsavel = $request->rg_responsavel;
        $item->email = $request->email;
        $item->whatsapp = $request->whatsapp;
        $item->telefone = $request->telefone;
        $item->contato = $request->contato;
        $item->endereco = $request->endereco;
        $item->cidade = $request->cidade;
        $item->estado = $request->estado;
        //pontuação resolver ainda...
        $item->pontuacao = $request->pontuacao;

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
            $item->avatar = $request->avatar->store('avatarAluno');

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

            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$avatarApagar and Storage::exists($avatarApagar) and $avatarApagar != 'avatarAluno/padrao.png') {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($avatarApagar);
            }

            //Redirecionamento para a rota alunoIndex, com mensagem de sucesso
            return redirect()->route('alunoIndex')->with('sucesso', '"' . $item->nome . '", salvo!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Não foi possível salvar as informações, tente novamente!');
        }
    }

    /*
    Função Deletar de Aluno
    - Responsável por excluir as informações de um aluno
    - $request: Recebe o Id do um aluno a ser excluido
    */
    public function deletar(Aluno $item)
    {
        //Validação de acesso
        if (!(new Services())->validarAdmin())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionar();


        $item->status = 0;

        //Deleta o aluno informado
        if ($item->save()) {

            //Redirecionamento para a rota alunoIndex, com mensagem de sucesso
            return redirect()->route('alunoIndex')->with('sucesso', 'Aluno excluido!');
        } else {
            //Redirecionamento para a rota alunoIndex, com mensagem de erro
            return redirect()->route('alunoIndex')->with('erro', 'Aluno não excluido!');
        }
    }


    /*
    Função Login de Aluno
    - Responsável pelo login do alunoistrador ao painel
    - $request: Recebe as credênciais de acesso informadas pelo internauta
    */
    public function login(Request $request)
    {
        //Validação das informações recebidas
        $validated = $request->validate([
            'usuario' => 'required|max:200',
            'senha' => 'required'
        ]);

        //Atribuição dos valores recebidos da váriavel $request para o objeto $item
        $usuario = $request->usuario;
        $senha = $request->senha;

        //Seleciona o aluno no banco de dados, usando as credencias de acesso
        $item = Aluno::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso")->where('usuario', '=', $usuario)->where('senha', '=', $senha)->first();

        //Verifica se existe um aluno com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {
            //Inícia a Sessão
            @session_start();

            //Obtem e preenche as informaçõs do admim encontrado
            $logado['id_aluno'] = $item->id;
            $logado['nome_aluno'] = $item->nome;
            $logado['usuario_aluno'] = $item->usuario;
            $logado['avatar_aluno'] = $item->avatar;
            $logado['tipo_aluno'] = $this->tipo($item->tipo);
            $logado['tipo_numero_aluno'] = $item->tipo;
            $logado['anotacoes_aluno'] = $item->anotacoes;
            $logado['cadastro_aluno'] = $item->cadastro;
            $logado['ultimo_acesso_aluno'] = $item->ultimo_acesso;

            //Cria uma sessão com as informações
            $_SESSION['aluno_cursos_start'] = $logado;

            //Verifica se o campo lembrar senha estava selecionado
            if (@$request->remember) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('aluno_usuario', $request->usuario, 4320);
                Cookie::queue('aluno_senha', $request->senha, 4320);
            } else {
                //Expira os Cookies de credências
                Cookie::expire('aluno_usuario');
                Cookie::expire('aluno_senha');
            }

            $item->touch();

            //Redirecionamento para a rota painelAluno, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelAluno')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de "' . $this->tipo($item->tipo) . '"');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->back()->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
                $request->except('senha')
            );
        }
    }

    /*
    Função Sair de Aluno
    - Responsável pelo logoff do painel do alunoistrador
    */
    public function sair()
    {
        //Inícia a Sessão
        @session_start();

        //Expira a sessão atual
        unset($_SESSION['aluno_cursos_start']);
        //Redirecionamento para a rota inicio, com mensagem de sucesso, sem uma sessão ativa
        return redirect()->route('acessoAluno')->with('sucesso', 'Sessão encerrada com sucesso!');
    }

    
    /*
    Função Tipo de Admin
    - Responsável por exibir o tipo do aluno
    - $tipo: Recebe o Id do tipo do aluno
    */
    public function tipo($tipo)
    {
        //Verifica o tipo do aluno
        switch ($tipo) {
            case 1:
                //Retorna o tipo Aluno
                return 'Aluno';
                break;
        }
    }
}

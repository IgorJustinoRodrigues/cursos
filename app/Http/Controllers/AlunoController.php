<?php
//Namespace do arquivo
namespace App\Http\Controllers;

//Dependências do controler
use App\Services\Services;
use App\Models\Aluno;
use App\Models\AnexoAula;
use App\Models\Aula;
use App\Models\AulaAluno;
use App\Models\Canvas;
use App\Models\CategoriaCurso;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\Perguntas;
use App\Models\Professor;
use App\Models\Respostas;
use App\Models\Servico;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

//Class AlunoController
class AlunoController extends Controller
{
    /*
    Função Acesso de Aluno do Site
    - Responsável por mostrar a tela de login de Aluno no site
    */
    public function acessoAluno($tela = 'login')
    {
        //Exibe a view
        return view('painelAluno.aluno.acessoAluno', [
            'tela' => $tela
        ]);
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
    - Responsável por mostrar a tela inícial do painel de aluno
    */
    public function painel()
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        $categorias = CategoriaCurso::where("status", '=', '1')->get();

        $meusCursos = $consulta = Matricula::join('cursos', 'cursos.id', '=', 'matriculas.curso_id')
            ->join('aulas', 'cursos.id', '=', 'aulas.curso_id')
            ->leftjoin('aula_alunos', function ($aula_alunos) {
                $aula_alunos->on('aulas.id', '=', 'aula_alunos.aula_id')
                    ->on('matriculas.aluno_id', '=', 'aula_alunos.aluno_id');
            })
            ->where('matriculas.aluno_id', '=', $_SESSION['aluno_cursos_start']->id)
            ->where('cursos.status', '=', 1)
            ->where('aulas.status', '=', 1)
            ->where('matriculas.status', '=', 1)
            ->selectRaw('cursos.*, count(aulas.id) as total_aula, count(aula_alunos.conclusao) as total_aula_concluido')
            ->groupBy('cursos.id')
            ->orderBy('aula_alunos.created_at', 'desc')
            ->limit(4)
            ->get();

        for ($i = 0; $i < count($meusCursos); $i++) {
            if ($meusCursos[$i]->total_aula_concluido > 0) {
                $meusCursos[$i]->porcentagem = ($meusCursos[$i]->total_aula_concluido * 100) / $meusCursos[$i]->total_aula;
            } else {
                $meusCursos[$i]->porcentagem = 0;
            }
        }

        $ultimasAulas = AulaAluno::join('aulas', 'aula_alunos.aula_id', '=', 'aulas.id')
            ->join('cursos', 'aula_alunos.curso_id', '=', 'cursos.id')
            ->where('aula_alunos.aluno_id', '=', $_SESSION['aluno_cursos_start']->id)
            ->selectRaw('aula_alunos.*, aulas.nome as aula, cursos.nome as curso')
            ->limit(5)
            ->get();

        //Exibe a tela inícial do painel de alunoistradores passando parametros para view
        return view('painelAluno.index', [
            'categorias' => $categorias,
            'meusCursos' => $meusCursos,
            'ultimasAulas' => $ultimasAulas
        ]);
    }

    public function confirmarMatricula()
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        @session_start();

        if (!isset($_SESSION['ativacao_start']) or $_SESSION['ativacao_start']['unidade'] == null) {
            return redirect()->route('inicio')->with('atencao', 'Informe um código válido para realizar a ativação!');
        } else {
            if ($_SESSION['ativacao_start']['aluno'] == null) {
                return redirect()->route('acessoAluno', 'cadastro')->with('atencao', 'Faça login para continuar!');
            }
            if ($_SESSION['ativacao_start']['curso'] == null) {
                return redirect()->route('site.cursos')->with('atencao', 'Escolha um curso!');
            }
        }

        //Exibe a tela inícial do painel de alunoistradores passando parametros para view
        return view('painelAluno.confirmarMatricula', [
            'curso' => $_SESSION['ativacao_start']['curso'],
            'aluno' => $_SESSION['ativacao_start']['aluno'],
            'matricula' => $_SESSION['ativacao_start']['matricula'],
            'vendedor' => $_SESSION['ativacao_start']['vendedor'],
            'unidade' => $_SESSION['ativacao_start']['unidade'],
        ]);
    }

    public function ativarMatricula()
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        @session_start();

        if (!isset($_SESSION['ativacao_start']) or $_SESSION['ativacao_start']['unidade'] == null) {
            return redirect()->route('inicio')->with('atencao', 'Informe um código válido para realizar a ativação!');
        } else {
            if ($_SESSION['ativacao_start']['aluno'] == null) {
                return redirect()->route('acessoAluno', 'cadastro')->with('atencao', 'Faça login para continuar!');
            }
            if ($_SESSION['ativacao_start']['curso'] == null) {
                return redirect()->route('site.cursos')->with('atencao', 'Escolha um curso!');
            }
        }

        $matricula = Matricula::find($_SESSION['ativacao_start']['matricula']->id);

        $matricula->aluno_id = $_SESSION['ativacao_start']['aluno']->id;
        $matricula->curso_id = $_SESSION['ativacao_start']['curso']->id;
        $matricula->data_ativacao = date('Y-m-d H:i:s');
        $matricula->status = 1;

        $resposta = $matricula->save();

        if ($resposta) {
            unset($_SESSION['ativacao_start']);

            return redirect()->route('painelAluno')->with('sucesso', 'Matrícula Realizada! ' . $_SESSION['aluno_cursos_start']->nome . ', você já pode acessar as aulas do curso.');
        } else {
            return redirect()->back()->with('atencao', 'Não foi possível efetivar a matrícula! Tente novamente.');
        }
    }

    public function trocarAlunoCurso($troca)
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        @session_start();

        if (!isset($_SESSION['ativacao_start']) or $_SESSION['ativacao_start']['unidade'] == null) {
            return redirect()->route('inicio')->with('atencao', 'Informe um código válido para realizar a ativação!');
        }

        $ativacao = $_SESSION['ativacao_start'];

        if ($troca == 'aluno') {
            if ($ativacao['matricula']->aluno_id != null) {
                return redirect()->back()->with('atencao', 'Não é possível trocar o aluno dessa matrícula!');
            }

            $ativacao['aluno'] = null;

            $_SESSION['ativacao_start'] = $ativacao;
            unset($_SESSION['aluno_cursos_start']);

            return redirect()->route('acessoAluno', 'cadastro')->with('padrao', 'Faça o seu cadastro ou login para continuar com a ativação do código.');
        } else if ($troca == 'curso') {
            if ($ativacao['matricula']->curso_id != null) {
                return redirect()->back()->with('atencao', 'Não é possível trocar o curso dessa matrícula!');
            }
            return redirect()->route('site.cursos')->with('padrao', 'Escolha um curso para continuar com a ativação do código.');
        } else {
            return redirect()->back()->with('atencao', 'Acesso incorreto!');
        }

        $ativacao['curso'] = null;
        $_SESSION['ativacao_start'] = $ativacao;
    }


    public function minhaConta()
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        $item = Aluno::find($_SESSION['aluno_cursos_start']->id);

        return view('painelAluno.aluno.minhaConta', [
            'item' => $item
        ]);
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
            'email' => 'required|email|max:100|unique:alunos,email',
            'senha' => 'required|min:6',
            'pontuacao' => 'required'
        ]);

        //Nova instância do Model Aluno
        $item = new Aluno();

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->nascimento = $request->nascimento;
        $item->sexo = $request->sexo;
        $item->whatsapp = $request->whatsapp;
        $item->telefone = $request->telefone;
        $item->contato = $request->contato;
        $item->cidade = $request->cidade;
        $item->estado = $request->estado;
        $item->email = $request->email;
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
            'email' => 'required|email|max:100|unique:alunos,email',
            'pontuacao' => 'required'
        ]);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->email = $request->email;
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
        $item->whatsapp = $request->whatsapp;
        $item->telefone = $request->telefone;
        $item->contato = $request->contato;
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

    public function salvarMinhasInformacoes(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        //inicia sessão
        @session_start();

        $id = $_SESSION['aluno_cursos_start']->id;

        //Validação das informações recebidas
        $validated = $request->validate([
            'nome' => 'required',
            'email' => "required|email|max:100|unique:alunos,email,{$id}",
        ]);

        $item = Aluno::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso")
            ->find($id);

        //Atribuição dos valores recebidos da váriavel $request
        $item->nome = $request->nome;
        $item->nascimento = $request->nascimento;
        $item->sexo = $request->sexo;
        $item->email = $request->email;
        $item->whatsapp = $request->whatsapp;
        $item->telefone = $request->telefone;
        $item->contato = $request->contato;
        $item->cidade = $request->cidade;
        $item->estado = $request->estado;

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

            $_SESSION['aluno_cursos_start'] = $item;

            if ($request->hasCookie('aluno_email') != false) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('aluno_email', $request->email, 4320);
                Cookie::queue('aluno_senha', $request->senha, 4320);
            }


            //Verifica se há imagem antiga para ser apagada e se caso exista, se é diferente do padrão
            if (@$avatarApagar and Storage::exists($avatarApagar) and $avatarApagar != 'avatarAluno/padrao.png') {
                //Deleta o arquivo físico da imagem antiga
                Storage::delete($avatarApagar);
            }

            //Redirecionamento para a rota alunoIndex, com mensagem de sucesso
            return redirect()->back()->with('sucesso', 'Edições salvas!');
        } else {
            //Redirecionamento para tela anterior com mensagem de erro
            return redirect()->back()->with('atencao', 'Algo deu errado, tente novamente!');
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
    Função Ver aula do Aluno 
    - Responsável por mostrar a tela de ver aula de Aluno 
    */
    public function verCursos(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        //inicia sessão
        @session_start();

        $consulta = Matricula::join('cursos', 'cursos.id', '=', 'matriculas.curso_id')
            ->join('aulas', 'cursos.id', '=', 'aulas.curso_id')
            ->leftjoin('aula_alunos', function ($aula_alunos) {
                $aula_alunos->on('aulas.id', '=', 'aula_alunos.aula_id')
                    ->on('matriculas.aluno_id', '=', 'aula_alunos.aluno_id');
            })
            ->where('matriculas.aluno_id', '=', $_SESSION['aluno_cursos_start']->id)
            ->where('cursos.status', '=', 1)
            ->where('aulas.status', '=', 1)
            ->where('matriculas.status', '=', 1);

        if (@$request->busca != '') {
            //Paginação dos registros com busca busca
            $consulta->where('cursos.nome', 'like', '%' . $request->busca . '%');
        }

        $items = $consulta->selectRaw('cursos.*, count(aulas.id) as total_aula, count(aula_alunos.conclusao) as total_aula_concluido')
            ->groupBy('cursos.id')
            ->paginate(9);

        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i]->total_aula_concluido > 0) {
                $items[$i]->porcentagem = ($items[$i]->total_aula_concluido * 100) / $items[$i]->total_aula;
            } else {
                $items[$i]->porcentagem = 0;
            }
        }

        //Exibe a view
        return view('painelAluno.aula.verCursos', ['paginacao' => $items, 'busca' => @$request->busca]);
    }

    public function concluirAulaQuiz(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        //Atribuição dos valores
        $aula_id = $request->aula_id;
        $curso_id = $request->curso_id;
        $aluno_id = $_SESSION['aluno_cursos_start']->id;

        $aula = Aula::find($aula_id);
        $curso = Curso::find($curso_id);
        $aula_aluno = AulaAluno::where('curso_id', '=', $curso_id)->where('aula_id', '=', $aula_id)->where('aluno_id', '=', $aluno_id)->first();

        $acertos = 0;
        $erro = 0;
        $i = 0;

        $pergunta_errada = array();
        $pergunta_certa = array();

        foreach ($request->pergunta_id as $linha) {
            $pergunta = Perguntas::find($linha);

            $indiceResposta = "resposta" . $i;

            if ($pergunta) {
                $resposta = Respostas::where('pergunta_id', '=', $pergunta->id)->find($request->input($indiceResposta));
                if ($resposta) {
                    $pergunta->marcada = $resposta;

                    if ($resposta->correta == 1) {
                        $pergunta_certa[] = $pergunta;
                        $acertos++;
                    } else {
                        $pergunta_errada[] = $pergunta;
                        $erro++;
                    }
                } else {
                    return redirect()->back()->with('atencao', "Encontramos um erro. Tente novamente!");
                }
            } else {
                return redirect()->back()->with('atencao', "Encontramos um erro. Tente novamente!");
            }

            $i++;
        }

        if ($acertos > 0) {
            $porcentagem = number_format(($acertos * 100) / ($acertos + $erro), 2, '.', '');
        } else {
            $porcentagem = 0;
        }

        if ($aula->avaliacao == 1) {
            if ($porcentagem >= 60) {
                if ($aula_aluno->nota == null or $aula_aluno->nota < $porcentagem) {
                    $nota = $porcentagem;

                    $aula_aluno->conclusao = date('Y-m-d H:i:s');
                    $aula_aluno->nota = $nota;
                    $aula_aluno->save();
                }
            }
        } else {
            $aula_aluno->conclusao = date('Y-m-d H:i:s');
            $aula_aluno->nota = '100';

            $aula_aluno->save();
        }

        //Exibe a tela de cadastro de aula
        return view('painelAluno.aula.notaQuiz', [
            'nota' => $porcentagem,
            'aula' => $aula,
            'curso' => $curso,
            'aula_aluno' => $aula_aluno,
            'pergunta_errada' => $pergunta_errada,
            'pergunta_certa' => $pergunta_certa
        ]);
    }

    public function concluirAula(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        //Atribuição dos valores
        $aula_aluno_id = $request->aula_aluno;

        $aula_aluno = AulaAluno::find($aula_aluno_id);
        if ($aula_aluno->conclusao != null) {
            $retorno = [
                'msg' => 'Essa aula foi concluida em ' . $aula_aluno->conclusao->format('d/m/Y') . ' às ' . $aula_aluno->conclusao->format('H:i'),
                'status' => 0
            ];

            return response()->json($retorno);
        }

        $aula = Aula::find($aula_aluno->aula_id);

        $aula_aluno->conclusao = date("Y-m-d H:i:s");
        if ($aula->tipo == 3 and $aula->avaliacao == 1) {
            if ($request->nota >= 0 and $request->nota <= 100) {
                $aula_aluno->nota = $request->nota;
            } else {
                $retorno = [
                    'msg' => 'A sua nota não foi registrada. Tente novamente!',
                    'status' => 0
                ];

                return response()->json($retorno);
            }
        } else {
            $aula_aluno->nota = 100;
        }
        $resposta = $aula_aluno->save();

        if ($resposta) {
            $retorno = [
                'msg' => 'Aula concluida!',
                'status' => 1
            ];
        } else {
            $retorno = [
                'msg' => 'Não foi possível concluir a aula!',
                'status' => 0
            ];
        }

        return response()->json($retorno);
    }

    public function avaliar(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        //Atribuição dos valores
        $aula_aluno_id = $request->aula_aluno;

        if ($request->nota < 0 and $request->nota > 5) {
            $retorno = [
                'msg' => 'Acesso incorreto!',
                'status' => 0
            ];

            return response()->json($retorno);
        }

        $aula_aluno = AulaAluno::find($aula_aluno_id);
        if ($aula_aluno->avaliacao_aula != null) {
            $retorno = [
                'msg' => 'Você já avaliou essa aula com ' . $aula_aluno->avaliacao_aula . ' estrelas!',
                'status' => 0
            ];

            return response()->json($retorno);
        }

        $aula_aluno->avaliacao_aula = $request->nota;

        $resposta = $aula_aluno->save();

        if ($resposta) {
            $retorno = [
                'msg' => 'Aula avaliada!',
                'status' => 1
            ];
        } else {
            $retorno = [
                'msg' => 'Não foi possível avaliar a aula!',
                'status' => 0
            ];
        }

        return response()->json($retorno);
    }

    public function anotacao(Request $request)
    {
        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAdmin, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        //Atribuição dos valores
        $aula_aluno_id = $request->aula_aluno;

        $aula_aluno = AulaAluno::find($aula_aluno_id);

        $aula_aluno->anotacao = $request->anotacao;

        $resposta = $aula_aluno->save();

        if ($resposta) {
            $retorno = [
                'msg' => 'Anotação salva!',
                'status' => 1
            ];
        } else {
            $retorno = [
                'msg' => 'Não foi possível salvar a anotação!',
                'status' => 0
            ];
        }

        return response()->json($retorno);
    }


    /*
    Função Ver aula do Aluno 
    - Responsável por mostrar a tela de ver aula de Aluno 
    */
    public function verAula($id_curso, $urlCurso, $id_aula, $titulo = '')
    {

        //Validação de acesso
        if (!(new Services())->validarAluno())
            //Redirecionamento para a rota acessoAluno, com mensagem de erro, sem uma sessão ativa
            return (new Services())->redirecionarAluno();

        $aluno_id = $_SESSION['aluno_cursos_start']->id;

        $curso = Curso::where('status', '=', '1')->find($id_curso);

        if (!$curso) {
            //Redirecionamento para a rota painelAluno, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelAluno')->with('atencao', "Curso não encontrado!");
        }

        $aula = Aula::where('status', '=', 1)->where('curso_id', '=', $curso->id)->find($id_aula);

        if (!$aula) {
            //Redirecionamento para a rota painelAluno, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('verAulas', [$curso->id, Str::slug($curso->nome, '-') . '.html'])->with('atencao', "Aula não encontrada!");
        }

        $matricula = Matricula::where('aluno_id', '=', $aluno_id)
            ->where('curso_id', '=', $curso->id)
            ->orderBy('data_ativacao', 'desc')
            ->first();

        if (!$matricula) {
            //Redirecionamento para a rota painelAluno, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelAluno')->with('atencao', "Você não está matriculado(a) no curso " . $curso->nome . "!");
        }

        if ($matricula->status == 2 and (strtotime($matricula->created_at) <= date('d/m/Y', strtotime('-90 days')))) {
            //Redirecionamento para a rota painelAluno, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelAluno')->with('atencao', "Você não tem acesso a esse curso!");
        }

        if (strtotime($matricula->data_ativacao) < strtotime(date('d-m-Y', strtotime('-90 days')))) {
            //Redirecionamento para a rota painelAluno, com mensagem de sucesso, com uma sessão ativa
            return redirect()->route('painelAluno')->with('atencao', "O período de acesso a esse curso já se encerrou!");
        }

        $aulas = Aula::join('cursos', 'cursos.id', '=', 'aulas.curso_id')
            ->join('matriculas', 'matriculas.curso_id', '=', 'cursos.id')
            ->leftjoin('aula_alunos', function ($aula_alunos) {
                $aula_alunos->on('aulas.id', '=', 'aula_alunos.aula_id')
                    ->on('matriculas.aluno_id', '=', 'aula_alunos.aluno_id');
            })
            ->where('aulas.curso_id', '=', $id_curso)
            ->where('aulas.status', '=', '1')
            ->selectRaw('aula_alunos.*, aulas.*, aula_alunos.id as id_aula_aluno, aula_alunos.updated_at as ultimo_acesso')
            ->groupBy('aulas.id')
            ->orderByRaw('-ordem desc')
            ->orderby('ordem', 'desc')
            ->get();

        $minutos_feitos = 0;
        $minutos_total = 0;
        $j = 0;

        for ($i = 0; $i < count($aulas); $i++) {
            if ($aulas[$i]->conclusao != null) {
                //Aula Feita
                $j = $i;
                $minutos_feitos += $aulas[$i]->duracao;
            }

            if ($aulas[$i]->id == $aula->id) {
                $atual = $aulas[$i];
                $atual->indice = $i;
            }

            $minutos_total += $aulas[$i]->duracao;
        }

        if (isset($aulas[$atual->indice - 1])) {
            $anterior = $aulas[$atual->indice - 1];
        } else {
            $anterior = null;
        }

        if (isset($aulas[$atual->indice + 1])) {
            $proxima = $aulas[$atual->indice + 1];
        } else {
            $proxima = null;
        }

        if ($minutos_feitos > 0) {
            $porcentagem = ($minutos_feitos * 100) / $minutos_total;
        } else {
            $porcentagem = 0;
        }

        if ($curso->aula_travada == 1) {
            if (isset($anterior) and $anterior->conclusao == null) {
                return redirect()->route('aula', [$curso->id, Str::slug($curso->nome, '-'), $anterior->id, Str::slug($anterior->nome, '-') . '.html'])->with('padrao', "Conclua a aula atual para ter acesso as próximas aulas!");
            }
        }

        if (!$atual->id_aula_aluno) {
            $aulaAluno = new AulaAluno();

            $aulaAluno->abertura = date('Y-m-d H:i:s');
            $aulaAluno->aluno_id = $aluno_id;
            $aulaAluno->aula_id = $aula->id;
            $aulaAluno->curso_id = $curso->id;

            if ($aulaAluno->save()) {
                $atual->id_aula_aluno = $aulaAluno->id;
            } else {
                return redirect()->route('alunoCursos')->with('atencao', 'Não foi possível iniciar essa aula no momento, tente mais tarde!');
            }
        }

        $professor = Professor::where('status', '=', '1')->find($curso->professor_id);
        $anexos = AnexoAula::where('aula_id', '=', $aula->id)->get();

        $avaliacaoAula = AulaAluno::where('curso_id', '=', $curso->id)
            ->where('aula_id', '=', $aula->id)
            ->avg('avaliacao_aula');

        if ($aula->tipo == 3) {
            $perguntas = Perguntas::where('aulas_id', '=', $aula->id)->inRandomOrder()->get();

            for ($i = 0; $i < count($perguntas); $i++) {
                $perguntas[$i]->respostas = Respostas::where('pergunta_id', '=', $perguntas[$i]->id)->inRandomOrder()->get();
            }

            $aula->perguntas = $perguntas;
        }

        switch ($aula->tipo) {
            case 1:
                $pagina = 'painelAluno.aula.verAulaVideo';
                break;

            case 2:
                $pagina = 'painelAluno.aula.verAulaTexto';
                break;

            case 3:
                $pagina = 'painelAluno.aula.verAulaQuiz';
                break;
        }

        //Exibe a view
        return view(
            $pagina,
            [
                'curso' => $curso,
                'aula' => $aula,
                'aulas' => $aulas,
                'professor' => $professor,
                'matricula' => $matricula,
                'atual' => $atual,
                'proxima' => $proxima,
                'minutos_feitos' => $minutos_feitos,
                'minutos_total' => $minutos_total,
                'porcentagem' => $porcentagem,
                'anexos' => $anexos,
                'avaliacaoAula' => $avaliacaoAula
            ]
        );
    }




    /*
    Função Login de Aluno
    - Responsável pelo login do alunoistrador ao painel
    - $request: Recebe as credênciais de acesso informadas pelo internauta
    */
    public function login(Request $request)
    {
        //Inícia a Sessão
        @session_start();

        if (isset($_SESSION['ativacao_start'])) {
            $ativacao = $_SESSION['ativacao_start'];

            if ($ativacao['matricula']->aluno_id != null or $ativacao['aluno'] != null) {
                return redirect()->route('painelAluno')->with('atencao', 'Acesso incorreto!');
            }
        } else {
            $ativacao = [
                'matricula' => null,
                'aluno' => null,
                'curso' => null,
                'unidade' => null,
                'vendedor' => null
            ];
        }

        if ($request->acao == 'cadastro') {

            if (!isset($_SESSION['ativacao_start']) or $_SESSION['ativacao_start']['aluno'] != null) {
                return redirect()->route('inicio')->with('atencao', 'Acesso incorreto!');
            }
            //Validação das informações recebidas
            $validated = $request->validate([
                'nome' => 'required',
                'email' => 'required|email|max:100|unique:alunos,email',
                'senha' => 'required|min:6'
            ]);

            if ($request->senha != $request->senha2) {
                return redirect()->back()->with('atencao', 'Senhas diferentes!');
            }
            //Nova instância do Model Aluno
            $item = new Aluno();
            $item->nome = $request->nome;
            $item->email = $request->email;
            $item->senha = md5($request->senha);

            $item->pontuacao = 0;
            //Fazer o envio por email para ativação da conta
            $item->status = 1;

            if (!$item->save()) {
                return redirect()->back()->with('atencao', 'Não foi possível fazer o seu cadastro, tente novamente!');
            }

            //Seleciona o aluno no banco de dados, usando as credencias de acesso
            $item = Aluno::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso")->find($item->id);
        } else {
            //Validação das informações recebidas
            $validated = $request->validate([
                'email' => 'required|email',
                'senha' => 'required|min:6'
            ]);

            //Atribuição dos valores recebidos da váriavel $request para o objeto $item
            $email = $request->email;
            $senha = md5($request->senha);

            //Seleciona o aluno no banco de dados, usando as credencias de acesso
            $item = Aluno::selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso")->where('email', '=', $email)->where('senha', '=', $senha)->where('status', '=', 1)->first();
        }


        //Verifica se existe um aluno com as credênciais informadas
        if (@$item->id != null and is_numeric($item->id)) {

            //Cria uma sessão com as informações
            $_SESSION['aluno_cursos_start'] = $item;

            if (isset($_SESSION['ativacao_start'])) {
                $ativacao['aluno'] = $item;
                //Atualizar uma sessão com as informações
                $_SESSION['ativacao_start'] = $ativacao;
            }

            //Verifica se o campo lembrar senha estava selecionado
            if (@$request->remember) {
                //Criar o Cookie com as credênciais com validade de 3 dias
                Cookie::queue('aluno_email', $request->email, 4320);
                Cookie::queue('aluno_senha', $request->senha, 4320);
            } else {
                //Expira os Cookies de credências
                Cookie::expire('aluno_email');
                Cookie::expire('aluno_senha');
            }

            $item->touch();

            if ($ativacao['aluno'] != null and $ativacao['curso'] != null) {
                //Confirmar matrícula
                return redirect()->route('confirmarMatricula');
            } else {
                //Redirecionamento para a rota painelAluno, com mensagem de sucesso, com uma sessão ativa
                return redirect()->route('painelAluno')->with('sucesso', 'Olá ' . $item->nome . ', você acessou o sistema com o perfil de "' . $this->tipo($item->tipo) . '"');
            }
        } else {
            //Redirecionamento para tela anterior com mensagem de erro e reenvio das informações preenchidas para correção, exceto as informações de senha
            return redirect()->route('acessoAluno')->with('atencao', 'Usuário e/ou senha incorretos!')->withInput(
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
        unset($_SESSION['ativacao_start']);

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

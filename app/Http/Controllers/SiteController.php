<?php

namespace App\Http\Controllers;

use App\Models\Ajuda;
use App\Models\Aluno;
use App\Models\AnexoAula;
use App\Models\Aula;
use App\Models\AulaAluno;
use App\Models\CategoriaAjuda;
use App\Models\CategoriaCurso;
use App\Models\Certificado;
use App\Models\Curso;
use App\Models\Matricula;
use App\Models\Parceiro;
use App\Models\Perguntas;
use App\Models\Professor;
use App\Models\Respostas;
use App\Models\Unidade;
use App\Models\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class SiteController extends Controller
{
    //Função index/início do Site 
    public function index()
    {

        //listagem da categoria de cursos e contagem de Quantos cursos tem em uma categoria
        $categorias = CategoriaCurso::join('cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->selectRaw('categoria_cursos.id, categoria_cursos.imagem as imagemCategoria, categoria_cursos.nome, count(categoria_cursos.id) as quantCursoCategoria')
            ->groupBy('cursos.categoria_id')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $principaisCategorias = Matricula::join("cursos", "matriculas.curso_id", "=", "cursos.id")
            ->join("categoria_cursos", "cursos.categoria_id", "=", "categoria_cursos.id")
            ->selectRaw("categoria_cursos.*")
            ->groupBy('categoria_cursos.id')
            ->orderByRaw('count(*) desc')
            ->limit(3)
            ->get();

        //Listagem de Parceiros
        $parceiros = Parceiro::where('visibilidade', '=', 1)->where('status', '=', 1)->get();

        //listagem de cursos 
        $cursos = Curso::join('categoria_cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->join('professors', 'professors.id', '=', 'cursos.professor_id')
            ->leftjoin('aulas', 'aulas.curso_id', '=', 'cursos.id')
            ->where('cursos.visibilidade', '=', 1)
            ->where('cursos.status', '=', 1)
            ->selectRaw('count(aulas.curso_id) as soma, cursos.id,cursos.tipo, cursos.imagem, cursos.nome, categoria_cursos.nome as categoria, categoria_cursos.id as categoria_id, professors.nome as professor, professors.id as id_professor, professors.avatar')
            ->groupBy('cursos.id')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        for ($i = 0; $i < count($cursos); $i++) {
            $cursos[$i]->estrelas = AulaAluno::where('curso_id', '=', $cursos[$i]->id)->avg('avaliacao_aula');
            $cursos[$i]->alunos = Matricula::where('curso_id', '=', $cursos[$i]->id)->count();
        }

        $metricas = array();

        $metricas['cursos'] = Curso::where('status', '=', 1)->where('visibilidade', '=', 1)->count();
        $metricas['alunos'] = Aluno::count();
        $metricas['certificados'] = Certificado::count();
        $metricas['horas_aulas_assistidas'] = intval(ceil(AulaAluno::join('aulas', 'aula_alunos.aula_id', '=', 'aulas.id')->sum('aulas.duracao') / 60));

        //Exibe a view 
        return view('site.index', [
            'parceiro' => $parceiros,
            'categoria' => $categorias,
            'curso' => $cursos,
            'categoriasMenu' => $categorias,
            'metricas' => $metricas,
            'principaisCategorias' => $principaisCategorias
        ]);
    }

    //Funçao de Ativação do Código sub-aba de início
    public function comoAtivarCodigo()
    {

        //listagem da categoria de cursos e contagem de Quantos cursos tem em uma categoria
        $categoriasMenu = CategoriaCurso::join('cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->selectRaw('categoria_cursos.id, categoria_cursos.imagem as imagemCategoria, categoria_cursos.nome, count(categoria_cursos.id) as quantCursoCategoria')
            ->groupBy('cursos.categoria_id')
            ->inRandomOrder()
            ->limit(5)
            ->get();
        
            //Exibe a view 
        return view('site.ativacaoCodigo', [

            'categoriasMenu' => $categoriasMenu
        ]);
    }

    
    //Funçao de Ativação do Código sub-aba de início
    public function certificado()
    {

        //listagem da categoria de cursos e contagem de Quantos cursos tem em uma categoria
        $categoriasMenu = CategoriaCurso::join('cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->selectRaw('categoria_cursos.id, categoria_cursos.imagem as imagemCategoria, categoria_cursos.nome, count(categoria_cursos.id) as quantCursoCategoria')
            ->groupBy('cursos.categoria_id')
            ->inRandomOrder()
            ->limit(5)
            ->get();
        
            //Exibe a view 
        return view('site.certificado', [

            'categoriasMenu' => $categoriasMenu
        ]);
    }


    public function ativacaoCodigo(Request $request)
    {
        $codigo = @$request->codigo;

        if ($codigo != '') {
            $matricula = Matricula::where('ativacao', '=', $codigo)->first();

            if ($matricula) {
                if ($matricula->status == 0) {
                    return redirect()->back()->with('atencao', 'O Código informado não é mais válido!')->withInput(['codigo']);
                }

                if ($matricula->data_ativacao != null) {
                    return redirect()->redirect('acessoAluno')->with('atencao', 'Código já ativado, utilize o seu usuário e senha para acessar o curso!')->withInput();
                }

                if (strtotime($matricula->created_at) < strtotime(date('Y-m-d', strtotime('-90 days')))) {
                    return redirect()->back()->with('atencao', 'O período para ativação do curso já se encerrou!')->withInput(['codigo']);
                }


                if ($matricula->aluno_id == null and $matricula->curso_id == null) {
                    //Não tem aluno nem curso

                    //Inícia a Sessão
                    @session_start();

                    if (isset($_SESSION['aluno_cursos_start']) and is_numeric($_SESSION['aluno_cursos_start']->id)) {
                        $aluno = $_SESSION['aluno_cursos_start'];
                    } else {
                        $aluno = null;
                    }

                    $ativacao = [
                        'matricula' => $matricula,
                        'aluno' => $aluno,
                        'curso' => null,
                        'unidade' => Unidade::where('status', '=', 1)->find($matricula->unidade_id),
                        'vendedor' => $matricula->vendedor_id != null ? Vendedor::where('status', '=', 1)->find($matricula->vendedor_id) : null
                    ];

                    //Cria uma sessão com as informações
                    $_SESSION['ativacao_start'] = $ativacao;

                    if (isset($_SESSION['aluno_cursos_start']) and is_numeric($_SESSION['aluno_cursos_start']->id)) {
                        return redirect()->route('confirmarMatricula');
                    } else {
                        return redirect()->route('site.cursos');
                    }
                } else if ($matricula->aluno_id == null) {
                    //Não tem aluno, mas tem curso

                    //Inícia a Sessão
                    @session_start();

                    if (isset($_SESSION['aluno_cursos_start']) and is_numeric($_SESSION['aluno_cursos_start']->id)) {
                        $aluno = $_SESSION['aluno_cursos_start'];
                    } else {
                        $aluno = null;
                    }

                    $ativacao = [
                        'matricula' => $matricula,
                        'aluno' => $aluno,
                        'curso' => Curso::where('status', '=', 1)->find($matricula->curso_id),
                        'unidade' => Unidade::where('status', '=', 1)->find($matricula->unidade_id),
                        'vendedor' => $matricula->vendedor_id != null ? Vendedor::where('status', '=', 1)->find($matricula->vendedor_id) : null
                    ];

                    //Cria uma sessão com as informações
                    $_SESSION['ativacao_start'] = $ativacao;

                    if (isset($_SESSION['aluno_cursos_start']) and is_numeric($_SESSION['aluno_cursos_start']->id)) {
                        return redirect()->route('confirmarMatricula');
                    } else {
                        return redirect()->route('acessoAluno', 'cadastro')->with('padrao', 'Cadastre-se ou faça login para confirmar a sua matrícula!');
                    }
                } else if ($matricula->curso_id == null) {
                    //Não tem curso, mas tem aluno

                    //Inícia a Sessão
                    @session_start();

                    //Seleciona o aluno no banco de dados, usando as credencias de acesso
                    $aluno = Aluno::where('status', '=', 1)->selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso")->find($matricula->aluno_id);
                    if ($aluno) {
                        //Cria uma sessão com as informações
                        $_SESSION['aluno_cursos_start'] = $aluno;

                        $ativacao = [
                            'matricula' => $matricula,
                            'aluno' => $aluno,
                            'curso' => null,
                            'unidade' => Unidade::where('status', '=', 1)->find($matricula->unidade_id),
                            'vendedor' => $matricula->vendedor_id != null ? Vendedor::where('status', '=', 1)->find($matricula->vendedor_id) : null
                        ];

                        //Cria uma sessão com as informações
                        $_SESSION['ativacao_start'] = $ativacao;

                        return redirect()->route('site.cursos');
                    } else {
                        unset($_SESSION['aluno_cursos_start']);
                        unset($_SESSION['ativacao_start']);

                        return redirect()->route('inicio')->with('atencao', 'O cadastro de aluno está com inconsistência de dados! Procure o suporte.')->withInput();
                    }
                } else {
                    //Tem aluno e curso

                    //Inícia a Sessão
                    @session_start();

                    //Seleciona o aluno no banco de dados, usando as credencias de acesso
                    $aluno = Aluno::where('status', '=', 1)->selectRaw("*, date_format(created_at, '%d/%m/%Y') as cadastro, date_format(updated_at, '%d/%m/%Y às %H:%i') as ultimo_acesso")->find($matricula->aluno_id);
                    if ($aluno) {
                        //Cria uma sessão com as informações
                        $_SESSION['aluno_cursos_start'] = $aluno;

                        $ativacao = [
                            'matricula' => $matricula,
                            'aluno' => $aluno,
                            'curso' => Curso::where('status', '=', 1)->find($matricula->curso_id),
                            'unidade' => Unidade::where('status', '=', 1)->find($matricula->unidade_id),
                            'vendedor' => $matricula->vendedor_id != null ? Vendedor::where('status', '=', 1)->find($matricula->vendedor_id) : null
                        ];

                        //Cria uma sessão com as informações
                        $_SESSION['ativacao_start'] = $ativacao;

                        return redirect()->route('confirmarMatricula');
                    } else {
                        unset($_SESSION['aluno_cursos_start']);
                        unset($_SESSION['ativacao_start']);

                        return redirect()->route('inicio')->with('atencao', 'O cadastro de aluno está com inconsistência de dados! Procure o suporte.')->withInput();
                    }
                }
            } else {
                return redirect()->back()->with('atencao', 'Código incorreto, verifique e tente novamente!')->withInput();
            }
        } else {
            return redirect()->back()->with('atencao', 'Você acessou essa página de forma incorreta!')->withInput();
        }
    }

    public function cancelarAtivacaoCodigo()
    {
        //Inícia a Sessão
        @session_start();

        //Expira a sessão atual
        unset($_SESSION['ativacao_start']);
        //Redirecionamento para a rota inicio, com mensagem de sucesso, sem uma sessão ativa
        return redirect()->route('inicio')->with('sucesso', 'Processo de Ativação de Código cancelado!');
    }

    public function escolhaCurso(Request $request)
    {
        //Inícia a Sessão
        @session_start();

        if (isset($_SESSION['ativacao_start']) and $_SESSION['ativacao_start']['matricula']->id != null) {
            $ativacao = $_SESSION['ativacao_start'];

            if ($ativacao['matricula']->curso_id != null) {
                if ($ativacao['aluno'] != null) {
                    return redirect()->route('confirmarMatricula')->with('atencao', 'Acesso incorreto!');
                } else {
                    return redirect()->route('acessoAluno', 'cadastro')->with('padrao', 'Cadastre-se ou faça login para confirmar a sua matrícula!');
                }
            }

            $curso_id = $request->curso_id;

            $curso = Curso::where('tipo', '=', $ativacao['matricula']->nivel_curso)->where('status', '=', 1)->where('visibilidade', '=', 1)->find($curso_id);
            if ($curso) {
                $ativacao['curso'] = $curso;

                //Atualizar uma sessão com as informações
                $_SESSION['ativacao_start'] = $ativacao;

                if ($ativacao['aluno'] != null) {
                    //Tela de confirmação de matrícula
                    return redirect()->route('confirmarMatricula');
                } else {
                    //Tela de cadastro ou login
                    return redirect()->route('acessoAluno', 'cadastro')->with('padrao', 'Cadastre-se ou faça login para confirmar a sua matrícula!');
                }
            } else {
                return redirect()->route('site.cursos')->with('atencao', 'Selecione um curso válido!')->withInput();
            }
        } else {
            return redirect()->back()->with('atencao', 'Você acessou essa página de forma incorreta!')->withInput();
        }
    }

    //Função de Cursos
    public function cursos(Request $request, $categoria = null)
    {

        $busca = $request->busca;

        if (!$categoria) {
            $categoria = $request->categoria;
        }

        $ordem = $request->ordem;

        $consulta = Curso::join('categoria_cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->join('professors', 'professors.id', '=', 'cursos.professor_id')
            ->leftjoin('aulas', 'aulas.curso_id', '=', 'cursos.id')
            ->where('cursos.visibilidade', '=', 1)
            ->where('cursos.status', '=', 1);

        if ($busca != '') {
            $consulta->where('cursos.nome', 'like', '%' . $busca . '%');
        }

        if ($categoria != '') {
            $consulta->where('cursos.categoria_id', '=', $categoria);
        }

        //Inícia a Sessão
        @session_start();

        if (isset($_SESSION['ativacao_start']) and $_SESSION['ativacao_start']['matricula']->id != null) {
            $consulta->where('cursos.tipo', '=', $_SESSION['ativacao_start']['matricula']->nivel_curso);
        }

        switch ($ordem) {
            case '1':
                //Destaque
                break;

            case '2':
                $consulta->orderBy('cursos.tipo', 'asc');
                break;

            case '3':
                $consulta->orderBy('cursos.tipo', 'desc');
                break;

            case '4':
                //Avaliações
                break;

            case '5':
                $consulta->orderBy('cursos.created_at', 'desc');
                break;
        }

        $cursos = $consulta->selectRaw('cursos.*, count(aulas.id) as total_aula, professors.nome as professor, professors.id as id_professor, professors.avatar as avatar_professor, categoria_cursos.nome as categoria')
            ->groupBy('cursos.id')
            ->paginate(9);

        for ($i = 0; $i < count($cursos); $i++) {
            $cursos[$i]->estrelas = AulaAluno::where('curso_id', '=', $cursos[$i]->id)->avg('avaliacao_aula');
            $cursos[$i]->alunos = Matricula::where('curso_id', '=', $cursos[$i]->id)->count();
        }

        $categorias = CategoriaCurso::where('status', '=', 1)->get();



        //listagem da categoria de cursos e contagem de Quantos cursos tem em uma categoria
        $categoriasMenu = CategoriaCurso::join('cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->selectRaw('categoria_cursos.id, categoria_cursos.imagem as imagemCategoria, categoria_cursos.nome, count(categoria_cursos.id) as quantCursoCategoria')
            ->groupBy('cursos.categoria_id')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        //Exibe a view 
        return view('site.cursos', [
            'curso' => $cursos,
            'categoriasMenu' => $categoriasMenu,
            'categorias' => $categorias,
            'busca' => $busca,
            'categoria' => $categoria,
            'ordem' => $ordem,
        ]);
    }

    public function lerCurso($id, $url)
    {
        $curso = Curso::where('status', '=', 1)
            ->where('visibilidade', '=', 1)
            ->find($id);

        if (!$curso) {
            return redirect()->back()->with('atencao', 'Curso não encontrado!')->withInput();
        }

        $curso->estrelas = AulaAluno::where('curso_id', '=', $curso->id)->avg('avaliacao_aula');
        $curso->alunos = Matricula::where('curso_id', '=', $curso->id)->count();

        $professor = Professor::where('status', '=', 1)->find($curso->professor_id);
        $categoria = CategoriaCurso::where('status', '=', 1)->find($curso->categoria_id);

        $aulas = Aula::where('status', '=', 1)->where('curso_id', '=', $curso->id)->get();

        $tempoTotal = 0;
        $totalQuiz = 0;
        foreach ($aulas as $linha) {
            $tempoTotal += $linha->duracao;
            if ($linha->tipo == 3) {
                $totalQuiz++;
            }
        }

        //Categorias Menu cabeçalho do site
        $categoriasMenu = CategoriaCurso::join('cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->selectRaw('categoria_cursos.id, categoria_cursos.imagem as imagemCategoria, categoria_cursos.nome, count(categoria_cursos.id) as quantCursoCategoria')
            ->groupBy('cursos.categoria_id')
            ->inRandomOrder()
            ->limit(5)
            ->get();


        //Exibe a view
        return view('site.lerCurso', [
            'categoriasMenu' => $categoriasMenu,
            'curso' => $curso,
            'professor' => $professor,
            'categoria' => $categoria,
            'aulas' => $aulas,
            'tempoTotal' => $tempoTotal,
            'quantidadeAula' => count($aulas),
            'totalQuiz' => $totalQuiz
        ]);
    }


    //Funçao de Ativação do Código sub-aba de início
    public function professor($id, $url)
    {


        $professor = Professor::where('status', '=', 1)
            ->find($id);

        if ($professor) {
            $mediaprofessor = AulaAluno::join('cursos', 'cursos.id', '=', 'aula_alunos.curso_id')
                ->where('cursos.professor_id', '=', $id)
                ->avg('aula_alunos.avaliacao_aula');

            //listagem de cursos 
            $cursos = Curso::join('categoria_cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
                ->join('professors', 'professors.id', '=', 'cursos.professor_id')
                ->leftjoin('aulas', 'aulas.curso_id', '=', 'cursos.id')
                ->where('cursos.visibilidade', '=', 1)
                ->where('cursos.status', '=', 1)
                ->where('cursos.professor_id', '=', $id)
                ->selectRaw('count(aulas.curso_id) as soma, cursos.id,cursos.tipo, cursos.imagem, cursos.nome, categoria_cursos.nome as categoria, categoria_cursos.id as categoria_id, professors.nome as professor, professors.id as id_professor, professors.avatar')
                ->groupBy('cursos.id')
                ->inRandomOrder()
                ->get();

            for ($i = 0; $i < count($cursos); $i++) {
                $cursos[$i]->estrelas = AulaAluno::where('curso_id', '=', $cursos[$i]->id)->avg('avaliacao_aula');
                $cursos[$i]->alunos = Matricula::where('curso_id', '=', $cursos[$i]->id)->count();
            }

            //listagem da categoria de cursos e contagem de Quantos cursos tem em uma categoria
            $categoriasMenu = CategoriaCurso::join('cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
                ->selectRaw('categoria_cursos.id, categoria_cursos.imagem as imagemCategoria, categoria_cursos.nome, count(categoria_cursos.id) as quantCursoCategoria')
                ->groupBy('cursos.categoria_id')
                ->inRandomOrder()
                ->limit(5)
                ->get();

            //Exibe a view 
            return view('site.professor', [
                'professor' => $professor,
                'categoriasMenu' => $categoriasMenu,
                'mediaProfessor' => (ceil($mediaprofessor)),
                'cursos' => $cursos
            ]);
        } else {
            return redirect()->route('inicio')->with('atencao', 'O Professor não foi encontrado. Tente novamente!')->withInput();
        }
    }

    public function aulaTeste($curso_id, $url = "")
    {
        $curso = Curso::where('status', '=', 1)->where('visibilidade', '=', 1)->find($curso_id);

        if ($curso) {
            $aulas = Aula::where('curso_id', '=', $curso->id)
                ->where('status', '=', '1')
                ->orderByRaw('-ordem desc')
                ->orderby('ordem', 'desc')
                ->get();

            if (!$aulas) {
                //Redirecionamento para a rota painelAluno, com mensagem de sucesso, com uma sessão ativa
                return redirect()->back()->with('atencao', 'O curso não foi encontrado. Tente novamente!')->withInput();
            }

            $professor = Professor::where('status', '=', '1')->find($curso->professor_id);
            $anexos = AnexoAula::where('aula_id', '=', $aulas[0]->id)->get();

            $aula = $aulas[0];

            //Exibe a view
            return view(
                'site.aulaTeste',
                [
                    'curso' => $curso,
                    'aula' => $aula,
                    'aulas' => $aulas,
                    'professor' => $professor,
                    'anexos' => $anexos,
                ]
            );
        } else {
            return redirect()->back()->with('atencao', 'O curso não foi encontrado. Tente novamente!')->withInput();
        }
    }

    //Função de Suporte
    public function ajuda()
    {

        //listagem da categoria de cursos e contagem de Quantos cursos tem em uma categoria
        $categoriasMenu = CategoriaCurso::join('cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->selectRaw('categoria_cursos.id, categoria_cursos.imagem as imagemCategoria, categoria_cursos.nome, count(categoria_cursos.id) as quantCursoCategoria')
            ->groupBy('cursos.categoria_id')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $categoriasAjuda = CategoriaAjuda::join('ajudas', 'ajudas.categoria_id', '=', 'categoria_ajudas.id')
            ->where('ajudas.local', '=', 1)
            ->where('ajudas.status', '=', 1)
            ->where('categoria_ajudas.status', '=', 1)
            ->selectRaw('categoria_ajudas.*')
            ->groupBy('categoria_ajudas.id')
            ->get();

        for ($i = 0; $i < count($categoriasAjuda); $i++) {
            $categoriasAjuda[$i]->telas = Ajuda::where('categoria_id', '=', $categoriasAjuda[$i]->id)->where('local', '=', 1)->get();
        }

        //Exibe a view 
        return view('site.ajuda', [
            'categoriasMenu' => $categoriasMenu,
            'categoriasAjuda' => $categoriasAjuda
        ]);
    }



    //Função de Suporte
    public function verAjuda($id, $url = '')
    {
        $ajuda = Ajuda::join('categoria_ajudas', 'ajudas.categoria_id', '=', 'categoria_ajudas.id')
            ->where('categoria_ajudas.status', '=', 1)
            ->where('ajudas.status', '=', 1)
            ->where('ajudas.local', '=', 1)
            ->where('ajudas.id', '=', $id)
            ->selectRaw('ajudas.*, categoria_ajudas.nome as categoria')
            ->first();

        if (!$ajuda) {
            return redirect()->route('site.ajuda')->with('atencao', 'Tela não encontrada!');
        }

        //listagem da categoria de cursos e contagem de Quantos cursos tem em uma categoria
        $categoriasMenu = CategoriaCurso::join('cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->selectRaw('categoria_cursos.id, categoria_cursos.imagem as imagemCategoria, categoria_cursos.nome, count(categoria_cursos.id) as quantCursoCategoria')
            ->groupBy('cursos.categoria_id')
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $categoriasAjuda = CategoriaAjuda::join('ajudas', 'ajudas.categoria_id', '=', 'categoria_ajudas.id')
            ->where('ajudas.local', '=', 1)
            ->where('ajudas.status', '=', 1)
            ->where('categoria_ajudas.status', '=', 1)
            ->selectRaw('categoria_ajudas.*')
            ->groupBy('categoria_ajudas.id')
            ->get();

        for ($i = 0; $i < count($categoriasAjuda); $i++) {
            $categoriasAjuda[$i]->telas = Ajuda::where('categoria_id', '=', $categoriasAjuda[$i]->id)->where('local', '=', 1)->get();

            if ($categoriasAjuda[$i]->id == $ajuda->categoria_id) {
                $telasAtual = $categoriasAjuda[$i]->telas;
            }
        }

        //Exibe a view 
        return view('site.verAjuda', [
            'ajuda' => $ajuda,
            'telasAtual' => $telasAtual,
            'categoriasMenu' => $categoriasMenu,
            'categoriasAjuda' => $categoriasAjuda
        ]);
    }




    public function login()
    {

        return view('aluno.login');
    }

    public function painel()
    {

        return view('aluno.painel');
    }

    public function info()
    {

        return view('aluno.info');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\CategoriaCurso;
use App\Models\Curso;
use App\Models\Parceiro;
use App\Models\Professor;
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
            ->get();

        //Listagem de Parceiros
        $parceiros = Parceiro::where('visibilidade', '=', 1)->where('status', '=', 1)->get();


        //listagem de cursos 
        $cursos = Curso::join('categoria_cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->join('professors', 'professors.id', '=', 'cursos.professor_id')
            ->leftjoin('aulas', 'aulas.curso_id', '=', 'cursos.id')
            ->where('cursos.visibilidade', '=', 1)
            ->where('cursos.status', '=', 1)
            ->selectRaw('count(aulas.curso_id) as soma, cursos.id,cursos.tipo, cursos.imagem, cursos.nome, categoria_cursos.nome as categoria, categoria_cursos.id as categoria_id, professors.nome as professor, professors.avatar')
            ->groupBy('aulas.curso_id')
            ->limit(6)
            ->get();


        //Exibe a view 
        return view('site.index', [
            'parceiro' => $parceiros,
            'categoria' => $categorias,
            'curso' => $cursos,
            'categoriasMenu' => $categorias
        ]);
    }

    //Funçao de Ativação do Código sub-aba de início
    public function ativacaoCodigo()
    {
        $categoriasMenu = CategoriaCurso::where('status', '=', 1)->get();
        //Exibe a view 
        return view('site.ativacaoCodigo', [

            'categoriasMenu' => $categoriasMenu
        ]);
    }

    //Função de Cursos
    public function cursos(Request $request, $categoria = null)
    {
        $busca = $request->busca;

        if(!$categoria){
            $categoria = $request->categoria;
        }

        $ordem = $request->ordem;

        $consulta = Curso::leftjoin('professors', 'professors.id', '=', 'cursos.professor_id')
            ->join('categoria_cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->where('cursos.visibilidade', '=', 1)
            ->where('cursos.status', '=', 1);

        if ($busca != '') {
            $consulta->where('cursos.nome', 'like', '%' . $busca . '%');
        }

        if ($categoria != '') {
            $consulta->where('cursos.categoria_id', '=', $categoria);
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

        $cursos = $consulta->selectRaw('cursos.*, professors.nome as professor, professors.avatar as avatar_professor, categoria_cursos.nome as categoria')
            ->paginate(9);


        $categoriasMenu = CategoriaCurso::where('status', '=', 1)->get();

        //Exibe a view 
        return view('site.cursos', [
            'curso' => $cursos,
            'categoriasMenu' => $categoriasMenu,
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
        $categoriasMenu = CategoriaCurso::where('status', '=', 1)->get();

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

    //Função de Suporte
    public function suporte()
    {

        $categoriasMenu = CategoriaCurso::where('status', '=', 1)->get();
        //Exibe a view 
        return view('site.suporte', [
            'categoriasMenu' => $categoriasMenu
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

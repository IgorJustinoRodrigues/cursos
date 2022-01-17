<?php

namespace App\Http\Controllers;

use App\Models\CategoriaCurso;
use App\Models\Curso;
use App\Models\Parceiro;
use Illuminate\Http\Request;

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
            ->where('cursos.visibilidade', '=', 1)
            ->where('cursos.status', '=', 1)
            ->selectRaw('cursos.id, cursos.imagem, cursos.nome, categoria_cursos.nome as categoria, categoria_cursos.id as categoria_id, professors.nome as professor, professors.avatar')
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

        //Exibe a view 
        return view('site.ativacaoCodigo');
    }

    //Função de Cursos
    public function cursos()
    {
        $cursos = Curso::join('categoria_cursos', 'categoria_cursos.id', '=', 'cursos.categoria_id')
            ->join('professors', 'professors.id', '=', 'cursos.professor_id')
            ->leftjoin('aulas', 'aulas.curso_id', '=', 'cursos.id')
            ->where('cursos.visibilidade', '=', 1)
            ->where('cursos.status', '=', 1)
            ->selectRaw('count(aulas.curso_id) as soma, cursos.id,cursos.tipo, cursos.imagem, cursos.nome, categoria_cursos.nome as categoria, categoria_cursos.id as categoria_id, professors.nome as professor, professors.avatar')
            ->groupBy('aulas.curso_id')
            ->paginate(9);


        $categoriasMenu = CategoriaCurso::where('status', '=', 1)->get();

        //Exibe a view 
        return view('site.cursos', [
            'curso' => $cursos,
            'categoriasMenu' => $categoriasMenu
        ]);
    }

    public function lerCurso($item, $url)
    {


        $categoriasMenu = CategoriaCurso::where('status', '=', 1)->get();

        //Exibe a view
        return view('site.lerCurso', [
            'categoriasMenu' => $categoriasMenu
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

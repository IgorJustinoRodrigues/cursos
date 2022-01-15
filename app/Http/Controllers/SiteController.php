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
        $categorias = CategoriaCurso::where('status', '=', 1)->get();

        $parceiros = Parceiro::where('visibilidade', '=', 1)->where('status', '=', 1)->get();

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
            ->where('cursos.visibilidade', '=', 1)
            ->where('cursos.status', '=', 1)
            ->selectRaw('cursos.id, cursos.imagem, cursos.nome, categoria_cursos.nome as categoria, categoria_cursos.id as categoria_id, professors.nome as professor, professors.avatar')
            ->paginate(1);

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

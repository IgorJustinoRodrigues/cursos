<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    //Função index/início do Site 
    public function index()
    {
        //Exibe a view 
        return view('site.index');
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

        //Exibe a view 
        return view('site.cursos');
    }

    public function lerCurso($item, $url)
    {
        $retorno = [
            'id' => 10,
            'titulo' => "Curso de Informática"
        ];

        //Exibe a view
        return view('site.lerCurso', ['info' => $retorno]);
    }

    //Função de Suporte
    public function suporte()
    {

        //Exibe a view 
        return view('site.suporte');
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

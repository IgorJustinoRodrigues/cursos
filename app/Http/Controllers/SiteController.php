<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {

        return view('site.index');
    }

    public function cursos()
    {

        return view('site.cursos');
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

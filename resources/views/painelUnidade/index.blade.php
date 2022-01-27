@extends('template.unidade')
@section('title', 'Painel da Unidade')

@section('footer')

@endsection

@section('conteudo')
    <h1 class="h2">Olá {{$_SESSION['unidade_cursos_start']->nome}}</h1>

    <div class="row">
        <div class="col-lg-7">

            
        </div>
        <div class="col-lg-5">

        </div>
    </div>

@endsection

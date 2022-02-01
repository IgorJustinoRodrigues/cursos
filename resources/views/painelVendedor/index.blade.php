@extends('template.vendedor')
@section('title', 'Painel de Vendedor')

@section('footer')

@endsection

@section('conteudo')
    <h1 class="h2">Olá Vendedor(a){{$_SESSION['vendedor_cursos_start']->nome}}</h1>

    <div class="row">
        <div class="col-lg-7">

            
        </div>
        <div class="col-lg-5">

        </div>
    </div>

@endsection

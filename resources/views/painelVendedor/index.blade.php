@extends('template.parceiro')
@section('title', 'Painel de Parceiro')

@section('footer')

@endsection

@section('conteudo')
    <h1 class="h2">Olá {{$_SESSION['parceiro_cursos_start']['nome_parceiro']}}</h1>

    <div class="row">
        <div class="col-lg-7">

            
        </div>
        <div class="col-lg-5">

        </div>
    </div>

@endsection

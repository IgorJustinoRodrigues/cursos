@extends('template.aluno')
@section('title', 'Matricula')
@section('menu-meusCursos', 'true')

@section('link')
<ol class="breadcrumb">
    <li class="breadcrumb-item">Matrícula</li>
    <li class="breadcrumb-item active">Confirmar Matrícula</li>
</ol>

@endsection

@section('conteudo')
    <div class="page ">
        <div class="container page__container p-0">
            <div class="row m-0">
                <div class="col-lg container-fluid page__container">
                    <div id="invoice">
                        <div class="card">
                            <div class="card-header media align-items-center">
                                <div class="media-body">
                                    <h1 class="card-title h2">Matrícula</h1>
                                    <div class="card-subtitle">Código de Ativação da Matrícula:
                                        {{ $matricula->ativacao }}
                                        <br>
                                        Gerado em {{ $matricula->created_at->format('d/m/Y') }} às
                                        {{ $matricula->created_at->format('H:i') }}
                                        <br>
                                        O código deverá ser ativo até
                                        {{ date('d/m/Y', strtotime('+90 days', strtotime($matricula->created_at))) }}
                                    </div>

                                </div>
                                <div class="media-right d-flex align-items-center">
                                    <a href="javascript:window.print()" class="btn btn-flush text-muted d-print-none"><i
                                            class="material-icons font-size-24pt">print</i></a>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <p class="text-black-70 m-0"><strong>ALUNO</strong></p>
                                        <h2>{{ $aluno->nome }}</h2>
                                        <div class="text-black-50">
                                            E-mail de acesso: {{ $aluno->email }}
                                            <br>
                                            Link de acesso: {{ route('inicio') }}
                                            <br>
                                            Cadastrado em {{ $aluno->created_at->format('d/m/Y') }} às
                                            {{ $aluno->created_at->format('H:i') }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <p class="text-black-70 m-0"><strong>CURSO</strong></p>
                                        <h2>{{ $curso->nome }}</h2>
                                        <div class="text-black-50">
                                            @if ($curso->descricao != '')
                                                {{ $curso->descricao }}
                                                <br>
                                            @endif
                                            {{ app(App\Http\Controllers\CursoController::class)->tipo($curso->tipo, true) }}
                                            <br>
                                            Aulas liberadas para acesso até {{ date('d/m/Y', strtotime('+90 days')) }}
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <hr>
                                        <p class="text-black-70 m-0"><strong>PARCEIRO</strong></p>
                                        <h2>{{ $unidade->nome }}</h2>
                                        <div class="text-black-50">
                                            @if (@$vendedor->nome != '')
                                                Vendedor: {{ $vendedor->nome }}
                                                <br>
                                            @endif
                                            Parceiro desde {{ $unidade->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <form action="{{ route('ativar') }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-block btn-lg">
                                                CONFIRMAR MATRÍCULA
                                            </button>    
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

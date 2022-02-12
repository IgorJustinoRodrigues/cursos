@extends('template.aluno')
@section('title', 'Matricula')
@section('menu-meusCursos', 'true')

@section('link')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Certificado</li>
        <li class="breadcrumb-item">Solicitação de Certificado</li>
        <li class="breadcrumb-item active">{{ $curso->nome }}</li>
    </ol>
@endsection

@section('footer')
    <script>
        function verifica() {
            if ($("#confirmacao").is(":checked")) {
                $("#btn-submit").prop('disabled', false);
            } else {
                $("#btn-submit").prop('disabled', true);
            }
        }
    </script>
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
                                    <h1 class="card-title h2">Solicitação de Certificado</h1>
                                    <div class="card-subtitle">Você concluiu
                                        {{ number_format($porcentagem, 2, ',', '') }}%
                                        do curso</div>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <p class="text-black-70 m-0"><strong>INFORMAÇÕES</strong></p>
                                        <h2 class="mb-0">Média obtida: {{ $media }}%</h2>
                                        <div class="text-black-50">
                                            Concluido:
                                            {{ app(App\Services\Services::class)->minuto_hora($minutos_feitos) }}<br>
                                            De: {{ app(App\Services\Services::class)->minuto_hora($minutos_total) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <p class="text-black-70 m-0"><strong>CURSO</strong></p>
                                        <h2 class="mb-0">{{ $curso->nome }}</h2>
                                        <div class="text-black-50">
                                            {{ app(App\Http\Controllers\CursoController::class)->tipo($curso->tipo, true) }}
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <hr>
                                        <p class="text-black-70 m-0"><strong>PARCEIRO</strong></p>
                                        <h2>{{ $parceiro->nome }}</h2>
                                        <div class="text-black-50">
                                            Parceiro desde {{ $parceiro->created_at->format('d/m/Y') }}
                                        </div>

                                        <hr>
                                        <div role="group" aria-labelledby="legend-confirmacao" class="col-md-9">
                                            <div class="custom-control custom-checkbox custom-control-inline">
                                                <input id="confirmacao" type="checkbox" class="custom-control-input"
                                                    onchange="verifica()" checked>
                                                <label for="confirmacao" class="custom-control-label">Confirmo que fiz e
                                                    estou ápito a solicitar o certificado do curso
                                                    {{ $curso->nome }}</label>
                                            </div>
                                            <small id="description-confirmacao" class="form-text text-muted">É obrigatório a
                                                confirmação do campo acima</small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <form action="{{ route('ativar') }}" method="post">
                                            @csrf
                                            <button type="submit" id="btn-submit" class="btn btn-success btn-block btn-lg">
                                                Gerar Certificado
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

@extends('template.aluno')

@section('link')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="student-dashboard.html">Início</a></li>
        <li class="breadcrumb-item"><a href="student-browse-courses.html">Meus Cursos</a></li>
        <li class="breadcrumb-item"><a href="student-browse-courses.html">{{ $curso->nome }}</a></li>
        <li class="breadcrumb-item active">{{ $aula->nome }}</li>
    </ol>
@endsection

@section('header')
    <style>
        .dourado {
            color: #ffd400 !important;
        }

    </style>
@endsection

@section('footer')
    <script>
        $(".estrela").hover(
            function() {
                nota($(this).attr('nota'));
            },
            function() {
                $(".estrela").removeClass("dourado");
                $(".estrela").removeClass("fa-star");
                $(".estrela").addClass("fa-star-o");
            }
        );

        function nota(total) {
            $(".estrela").removeClass("dourado");
            $(".estrela").removeClass("fa-star");
            $(".estrela").addClass("fa-star-o");

            for (var i = 1; i <= total; i++) {
                $("#estrela" + i).addClass("dourado");
                $("#estrela" + i).addClass("fa-star");
                $("#estrela" + i).removeClass("fa-star-o");
            }
        }

        function concluir() {
            Lobibox.notify('success', {
                size: 'mini',
                sound: false,
                icon: false,
                position: 'top right',
                msg: "Aula Concluida!"
            });

            $("#div-concluir").addClass('d-none');
            $("#div-aula-concluida").removeClass('d-none');

        }

        $("#div-concluir").addClass('d-none');
        $("#div-aula-concluida").addClass('d-none');
        
        function habilita_concluir() {
            $("#div-concluir").removeClass('d-none');
        }

        setTimeout(concluir, {{ (($aula->duracao * 60) * 0.9) * 1000 }});
        setTimeout(habilita_concluir, {{ (($aula->duracao * 60) * 0.5) * 1000 }});
    </script>
@endsection

@section('conteudo')
    <div class="row">
        <div class="col-md-8 mb-2">
            <div class="card">
                <div class="embed-responsive embed-responsive-16by9">
                    {!! $aula->video !!}
                </div>
                <div class="card-body">
                    <b>
                        {!! app(App\Http\Controllers\AulaController::class)->tipo($aula->tipo, $aula->avaliacao, true) !!} {{ $aula->nome }}
                    </b>
                    <small class="text-muted-light">
                        - {{ app(App\Services\Services::class)->minuto_hora($aula->duracao) }}
                    </small>
                    <hr>
                    {{ $aula->descricao }}
                </div>
            </div>
            @if (trim($aula->texto) != '<p><br></p>' and $aula->texto != null)
                <div class="card">
                    <div class="card-body">
                        {!! $aula->texto !!}
                    </div>
                </div>
            @endif
            <!-- Lessons -->
            <textarea id="anotacao" placeholder="Suas anotações desta aula" rows="4" class="form-control"></textarea>
            <div class="d-flex mt-2">
                <div class="flex">
                    <a href="{{ route('verAulas', [$curso->id, Str::slug($curso->nome, '-') . '.html']) }}"
                        class="btn btn-sm btn-default btn-wide">Voltar para aulas</a>
                </div>
                <a class="btn btn-sm btn-success">Salvar Anotações</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" id="div-concluir">
                <div class="card-body text-center">
                    <a href="student-cart.html" class="btn btn-success btn-block">
                        Concluir Aula
                    </a>
                </div>
            </div>
            <div class="card" id="div-aula-concluida">
                <div class="card-body text-center">
                    <a href="" class="btn btn-success btn-block">
                        Próxima Aula
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <a href="student-cart.html" class="btn btn-primary btn-block flex-column">
                        <i class="material-icons" style="font-size: 20px">cloud_download</i> Baixar Conteúdo Auxiliar
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-left">
                            @if ($professor->avatar != '')
                                <img src="{{ URL::asset('storage/' . $professor->avatar) }}" width="50"
                                    class="rounded-circle">
                            @else
                                <img src="{{ URL::asset('storage/avatarProfessor/padrao.png') }}" width="50"
                                    class="rounded-circle">
                            @endif
                        </div>
                        <div class="media-body">
                            <h4 class="card-title"><a>{{ $professor->nome }}</a></h4>
                            <p class="card-subtitle">
                                @if ($curso->cooprodutor)
                                    Coprodução: {{ $curso->cooprodutor }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>{!! $professor->curriculo !!}</p>
                    @if ($professor->email)
                        <a href="mailto:{{ $professor->email }}" target="_blank" class="btn btn-light"><i
                                class="fas fa-envelope"></i></a>
                    @endif
                    @if ($professor->facebook)
                        <a href="{{ $professor->facebook }}" target="_blank" class="btn btn-light"><i
                                class="fab fa-facebook"></i></a>
                    @endif
                    @if ($professor->instagram)
                        <a href="{{ $professor->instagram }}" target="_blank" class="btn btn-light"><i
                                class="fab fa-instagram"></i></a>
                    @endif
                    @if ($professor->linkedin)
                        <a href="{{ $professor->linkedin }}" target="_blank" class="btn btn-light"><i
                                class="fab fa-linkedin"></i></a>
                    @endif
                    @if ($professor->site)
                        <a href="{{ $professor->site }}" target="_blank" class="btn btn-light"><i
                                class="fas fa-globe"></i></a>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="media align-items-center">
                        <div class="media-left">
                            @if ($curso->imagem != '')
                                <img src="{{ URL::asset('storage/' . $curso->imagem) }}" width="50">
                            @else
                                <img src="{{ URL::asset('storage/imagemCurso/padrao.png') }}" width="50">
                            @endif
                        </div>
                        <div class="media-body">
                            <h4 class="card-title"><a>{{ $curso->nome }}</a></h4>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-fit">
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <div class="media-left">
                                <i class="material-icons text-muted-light">assessment</i>
                            </div>
                            <div class="media-body">
                                Duração do curso {{ app(App\Services\Services::class)->minuto_hora($tempoTotal) }}
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <div class="media-left">
                                <i class="material-icons text-muted-light">schedule</i>
                            </div>
                            <div class="media-body">
                                Aulas concluidas
                                {{ app(App\Services\Services::class)->minuto_hora($tempoTotalConcluido) }}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Avalie a aula</h4>
                </div>
                <div class="card-body">
                    <div class="rating">
                        <i class="fa fa-star-o estrela" style="font-size: 20px" onclick="avaliar(1)" id="estrela1"
                            nota='1'></i>
                        <i class="fa fa-star-o estrela" style="font-size: 20px" onclick="avaliar(2)" id="estrela2"
                            nota='2'></i>
                        <i class="fa fa-star-o estrela" style="font-size: 20px" onclick="avaliar(3)" id="estrela3"
                            nota='3'></i>
                        <i class="fa fa-star-o estrela" style="font-size: 20px" onclick="avaliar(4)" id="estrela4"
                            nota='4'></i>
                        <i class="fa fa-star-o estrela" style="font-size: 20px" onclick="avaliar(5)" id="estrela5"
                            nota='5'></i>
                    </div>
                    <small class="text-muted">Média 4.5</small>
                </div>
            </div>
        </div>
    </div>
@endsection

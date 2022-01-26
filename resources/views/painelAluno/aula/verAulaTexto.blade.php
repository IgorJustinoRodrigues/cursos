@extends('template.aluno')

@section('title', $aula->nome . ' | ' . $curso->nome)

@section('link')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('painelAluno') }}">Início</a></li>
        <li class="breadcrumb-item"><a href="{{ route('alunoCursos') }}">Meus Cursos</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('verAulas', [$curso->id, Str::slug($curso->nome, '-') . '.html']) }}">{{ $curso->nome }}</a>
        </li>
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
        function anotacao() {
            var anotacao = $("#anotacao").val();

            $.ajax({
                type: 'post',
                url: "{{ route('anotacao') }}",
                data: {
                    aula_aluno: {{ $atual->id_aula_aluno }},
                    anotacao: anotacao,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == '1') {
                        Lobibox.notify('success', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: data.msg
                        });
                    } else {
                        Lobibox.notify('warning', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: data.msg
                        });
                    }
                }
            });
        }

        function avaliar(nota) {
            if (confirm("A sua avaliação é " + nota + " estrelas?")) {
                $.ajax({
                    type: 'post',
                    url: "{{ route('avaliar') }}",
                    data: {
                        aula_aluno: {{ $atual->id_aula_aluno }},
                        nota: nota,
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == '1') {
                            Lobibox.notify('success', {
                                size: 'mini',
                                sound: false,
                                icon: false,
                                position: 'top right',
                                msg: data.msg
                            });

                            $("#div-avaliacao").empty();

                            var div = '<div class="card-header">';
                            div += '<h4 class="card-title">Sua avaliação</h4>';
                            div += '</div>';
                            div += '<div class="card-body">';
                            div += '<div class="rating">';

                            for (i = 1; i < 6; i++) {
                                if (i <= nota) {
                                    div += '<i class="fa fa-star dourado" style="font-size: 20px"></i>';
                                } else {
                                    div += '<i class="fa fa-star-o" style="font-size: 20px"></i>';
                                }
                            }
                            div += '</div>';

                            $("#div-avaliacao").html(div);
                        } else {
                            Lobibox.notify('warning', {
                                size: 'mini',
                                sound: false,
                                icon: false,
                                position: 'top right',
                                msg: data.msg
                            });
                        }
                    }
                });
            }
        }

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

        window.concluido = false;

        function concluir() {
            if (!window.concluido) {
                window.concluido = true;
                $.ajax({
                    type: 'post',
                    url: "{{ route('concluirAula') }}",
                    data: {
                        aula_aluno: {{ $atual->id_aula_aluno }},
                        _token: $("input[name='_token']").val()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.status == '1') {
                            Lobibox.notify('success', {
                                size: 'mini',
                                sound: false,
                                icon: false,
                                position: 'top right',
                                msg: data.msg
                            });

                            $("#div-concluir").addClass('d-none');
                            $("#div-aula-concluida").removeClass('d-none');
                        } else {
                            Lobibox.notify('error', {
                                size: 'mini',
                                sound: false,
                                icon: false,
                                position: 'top right',
                                msg: data.msg
                            });

                            $("#div-concluir").removeClass('d-none');
                            $("#div-aula-concluida").addClass('d-none');
                        }
                    },
                    error: function(data) {
                        Lobibox.notify('error', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: "O sistema está passando por instabilidades no momento! Tente novamente mais tarde."
                        });
                        window.concluido = false;
                    }
                });
            }
        }

        function habilita_concluir() {
            if (!window.concluido) {
                $("#div-concluir").removeClass('d-none');
            }
        }

        @if ($atual->conclusao != null)
            $("#div-concluir").addClass('d-none');
        
        @else
            $("#div-concluir").addClass('d-none');
            $("#div-aula-concluida").addClass('d-none');
        
            setTimeout(concluir, {{ $aula->duracao * 60 * 0.9 * 1000 }});
            setTimeout(habilita_concluir, {{ $aula->duracao * 60 * 0.5 * 1000 }});
        @endif
    </script>
@endsection

@section('conteudo')
    @csrf
    <div class="row">
        <div class="col-md-8 mb-2">
            <div class="card">
                <div class="card-body">
                    <b>
                        {!! app(App\Http\Controllers\AulaController::class)->tipo($aula->tipo, $aula->avaliacao, true) !!} {{ $aula->nome }}
                    </b>
                    <small class="text-muted-light">
                        - {{ app(App\Services\Services::class)->minuto_hora($aula->duracao) }}
                    </small>
                    <hr>
                    {!! $aula->texto !!}
                    <hr>
                    {{ $aula->descricao }}
                </div>
            </div>
           
            <!-- Lessons -->
            <textarea id="anotacao" placeholder="Suas anotações desta aula" rows="4"
                class="form-control">{{ $atual->anotacao }}</textarea>
            <div class="d-flex mt-2">
                <div class="flex">
                    <a href="{{ route('verAulas', [$curso->id, Str::slug($curso->nome, '-') . '.html']) }}"
                        class="btn btn-sm btn-default btn-wide">Voltar para aulas</a>
                </div>
                <a class="btn btn-sm btn-success" onclick="anotacao()">Salvar Anotações</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" id="div-concluir">
                <div class="card-body text-center">
                    <a onclick="concluir()" class="btn btn-success btn-block">
                        Concluir Aula
                    </a>
                </div>
            </div>
            <div class="card" id="div-aula-concluida">
                <div class="card-body text-center">
                    @if(isset($proxima))
                    <a href="{{ route('aula', [$curso->id, Str::slug($curso->nome, '-'), $proxima->id, Str::slug($proxima->nome, '-') . '.html']) }}"
                        class="btn btn-dark btn-block">
                        Próxima Aula <i class="material-icons mr-1">trending_flat</i>
                    </a>
                    @else
                    <a href="{{ route('verAulas', [$curso->id, Str::slug($curso->nome, '-') . '.html']) }}"
                        class="btn btn-dark btn-block">
                        <i class="material-icons mr-1">dvr</i> 
                        Ver todas as aulas
                    </a>
                    @endif
                </div>
            </div>
            @if (count($anexos) > 0)
                <div class="card">
                    <div class="card-body text-center">
                        <a class="btn btn-primary btn-block"> Conteúdos Auxiliares
                        </a>
                    </div>
                    <ul class="card list-group list-group-fit">
                        @foreach ($anexos as $linha)
                            <li class="list-group-item">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="text-muted-light">{{ $linha->nome }}</div>
                                    </div>
                                    <div class="media-right">
                                        <a href="{{ URL::asset('storage/' . $linha->arquivo) }}" download="{{ $linha->nome }}" class="btn btn-success">
                                            <i class="material-icons mr-1">file_download</i> Baixar
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
                                Duração do curso {{ app(App\Services\Services::class)->minuto_hora($minutos_total) }}
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
                                {{ app(App\Services\Services::class)->minuto_hora($minutos_feitos) }}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card">
                @if ($atual->avaliacao_aula != null)
                    <div class="card-header">
                        <h4 class="card-title">Sua Avaliação</h4>
                    </div>
                    <div class="card-body">
                        <div class="rating">
                            @for ($i = 1; $i < 6; $i++)
                                @if ($i <= $atual->avaliacao_aula)
                                    <i class="fa fa-star dourado" style="font-size: 20px"></i>
                                @else
                                    <i class="fa fa-star-o" style="font-size: 20px"></i>
                                @endif
                            @endfor
                        @else
                            <div id="div-avaliacao">
                                <div class="card-header">
                                    <h4 class="card-title">Avalie a aula</h4>
                                </div>
                                <div class="card-body">
                                    <div class="rating">

                                        <i class="fa fa-star-o estrela" style="font-size: 20px" onclick="avaliar(1)"
                                            id="estrela1" nota='1'></i>
                                        <i class="fa fa-star-o estrela" style="font-size: 20px" onclick="avaliar(2)"
                                            id="estrela2" nota='2'></i>
                                        <i class="fa fa-star-o estrela" style="font-size: 20px" onclick="avaliar(3)"
                                            id="estrela3" nota='3'></i>
                                        <i class="fa fa-star-o estrela" style="font-size: 20px" onclick="avaliar(4)"
                                            id="estrela4" nota='4'></i>
                                        <i class="fa fa-star-o estrela" style="font-size: 20px" onclick="avaliar(5)"
                                            id="estrela5" nota='5'></i>
                                    </div>
                @endif
            </div>
            @if ($avaliacaoAula)
                <small class="text-muted">Média {{ $avaliacaoAula }}</small>
            @endif
        </div>
    </div>
    </div>
    </div>
@endsection

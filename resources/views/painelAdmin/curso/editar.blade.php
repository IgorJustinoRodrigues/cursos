@extends('template.admin')
@section('title', 'Curso')
@section('menu-curso', 'true')


@section('header')
    <link type="text/css" href="{{ URL::asset('template/css/quill.css') }}" rel="stylesheet">
    <!-- Touchspin -->
    <link rel="stylesheet" href="{{ URL::asset('template/css/bootstrap-touchspin.css') }}">
    <link href="{{ URL::asset('template/css/select2.min.css') }}" rel="stylesheet" />
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ URL::asset('template/css/nestable.css') }}">
@endsection

@section('footer')
    <script src="{{ URL::asset('template/vendor/quill.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/quill.js') }}"></script>
    <!-- Vendor JS -->
    <script src="{{ URL::asset('template/vendor/jquery.nestable.js') }}"></script>
    <script src="{{ URL::asset('template/vendor/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ URL::asset('template/js/select2.min.js') }}"></script>
    <!-- Initialize -->
    <script src="{{ URL::asset('template/js/nestable.js') }}"></script>
    <script src="{{ URL::asset('template/js/touchspin.js') }}"></script>
    <script>
        function prepararSubmit() {
            var descricao = $(".ql-editor").html();
            $("#input-descricao").val(descricao);

            return true;
        }

        $(document).ready(function() {
            $('.select2').select2();
        });

        document.getElementById("nestable").onchange = function() {
            myFunction()
        };

        function myFunction() {
            var i = 1;
            $(".nestable-item").each(function(index) {
                $('#aula' + $(this).attr('data-id')).text(i + '.');
                $(this).attr('data-ordem', i++);
                console.log('id: ' + $(this).attr('data-id'));
                console.log('ordem: ' + $(this).attr('data-ordem'));
            });
        }
    </script>


@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Edição de Curso</h1>
        </div>

        <div class="card card-body">

            <!-- Inicio do Tabs -->
            <div class="card">
                <ul class="nav nav-tabs nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link
                        @if ($menu == '')
                        active    
                        @endif
                        "
                            href="#curso" data-toggle="tab">Curso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link
                        @if ($menu == 'aulas')
                        active    
                        @endif
                        "
                            href="#aulas_curso" data-toggle="tab">Aulas do Curso</a>
                    </li>
                </ul>
                <div class="card-body tab-content">
                    <div class="tab-pane
                    @if ($menu == '')
                        active    
                    @endif
                    "
                        id="curso">
                        <form method="POST" action="{{ route('cursoSalvar', $item) }}"
                            onsubmit="return prepararSubmit();" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="id" value="{{ $item->id }}">
                            <input type="hidden" name="descricao" id="input-descricao">

                            <div class="form-row">
                                <div class="col-9 col-md-8 mb-3">
                                    <label class="form-label" for="nome">Nome do Curso</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                        value="{{ $item->nome }}" required="">
                                </div>
                                <div class="col-12 col-md-4 mb-3">
                                    <label class="form-label" for="imagem">Imagem</label>
                                    <input type="file" class="form-control" id="imagem" name="imagem">
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="col-12 col-md-12 mb-3">
                                    <label class="form-label">Descrição do Curso</label>
                                    <div class="form-control" id="descricao" data-toggle="quill" style="height: 150px;">
                                        {!! $item->descricao !!}</div>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="professor">Professor</label>
                                    <input type="text" id="professor" class="form-control" value="{{ $professor->nome }}" readonly>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="categoria">Categoria de Curso</label>
                                    <select id="categoria" class="form-control custom-select select2" name="categoria">
                                        <option></option>
                                        @foreach ($categorias as $linha)
                                        <option @if ($item->categoria_id == $linha->id) selected @endif value="{{ $linha->id }}">
                                            {{ $linha->nome }}</option>                                            
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-9 col-md-12 mb-3">
                                    <label class="form-label" for="cooprodutor">Cooprodutor</label>
                                    <input type="text" class="form-control" id="cooprodutor" name="cooprodutor"
                                        placeholder="Cooprodutor" value="{{ $item->cooprodutor }}">
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="visibilidade">Visibilidade</label>
                                    <select id="visibilidade" class="form-control custom-select" name="visibilidade">
                                        <option @if ($item->visibilidade == 1) selected @endif value="1">Visível</option>
                                        <option @if ($item->visibilidade == 2) selected @endif value="2">Não Visível</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="tipo">Tipo do Curso</label>
                                    <select id="tipo" class="form-control custom-select" name="tipo">
                                        <option @if ($item->tipo == 1) selected @endif value="1">Curso Iniciante | Até 5 Aulas | R$ 18,00
                                        </option>
                                        <option @if ($item->tipo == 2) selected @endif value="2">Curso Intermediário | Até 10 Aulas | R$
                                            26,00</option>
                                        <option @if ($item->tipo == 3) selected @endif value="3">Curso Avançado | Mais de 15 Aulas | R$ 38,00</option>
                                        <option @if ($item->tipo == 4) selected @endif value="4">Treinamento</option>
                                    </select>
                                </div>


                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="status">Status</label>
                                    <select id="status" class="form-control custom-select" name="status">
                                        <option @if ($item->status == 1) selected @endif value="1">Ativo</option>
                                        <option @if ($item->status == 2) selected @endif value="2">Inativo</option>
                                    </select>
                                </div>

                            </div>
                            <hr>
                            <div class="d-flex">
                                <div class="flex">
                                    <a href="{{ route('cursoIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                                </div>
                                <button class="btn btn-success" type="submit">Salvar</button>
                            </div>
                        </form>

                    </div>
                    <div class="tab-pane
                    @if ($menu == 'aulas')
                    active    
                    @endif
                    "
                        id="aulas_curso">
                        <div class="card-header">
                            <a href="{{ route('aulaIndex', [$item]) }}" class="btn btn-outline-secondary">
                                Gerenciar Aulas&nbsp;&nbsp;
                                <i class="material-icons">dvr</i></a>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                
                                <!-- Lessons -->
                                <ul class="card list-group list-group-fit">
                                    @php $i = 1 @endphp
                                    @php $total_minuto = 0 @endphp
                                    @foreach($aulas as $linha)
                                        @php $total_minuto += $linha->duracao @endphp
                                        <li class="list-group-item">
                                            <div class="media">
                                                <div class="media-left">
                                                    <div class="text-muted">{{$i++}}.</div>
                                                </div>
                                                <div class="media-body">
                                                    <a href="{{ route("aulaEditar", [$item, $linha]) }}">{{ $linha->nome }} | {{ app(App\Http\Controllers\AulaController::class)->tipo( $linha->tipo, $linha->avaliacao ) }}</a>
                                                </div>
                                                <div class="media-right">
                                                    <small class="text-muted-light">{{ app(App\Services\Services::class)->minuto_hora( $linha->duracao ) }}</small>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="card">
                                    <div class="card-header">
                                        <div class="media align-items-center">
                                            <div class="media-left">
                                                @if ($professor->avatar != '')
                                                    <img src="{{ URL::asset('storage/' . $professor->avatar) }}"
                                                    width="50"
                                                    class="rounded-circle">
                                                @else
                                                    <img src="{{ URL::asset('storage/avatarProfessor/padrao.png') }}"
                                                    width="50"
                                                    class="rounded-circle">
                                                @endif
                                            </div>
                                            <div class="media-body">
                                                <h4 class="card-title"><a href="{{ route("professorEditar", $professor) }}" target="_blank">{{ $professor->nome }}</a></h4>
                                                <p class="card-subtitle">Professor</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $professor->curriculo }}</p>
                                        @if($professor->email)
                                        <a href="mailto:{{$professor->email}}" target="_blank"
                                           class="btn btn-light"><i class="fas fa-envelope"></i></a>
                                        @endif
                                        @if($professor->facebook)
                                        <a href="{{$professor->facebook}}" target="_blank"
                                           class="btn btn-light"><i class="fab fa-facebook"></i></a>
                                        @endif
                                        @if($professor->instagram)
                                        <a href="{{$professor->instagram}}" target="_blank"
                                           class="btn btn-light"><i class="fab fa-instagram"></i></a>
                                        @endif
                                        @if($professor->linkedin)
                                        <a href="{{$professor->linkedin}}" target="_blank"
                                           class="btn btn-light"><i class="fab fa-linkedin"></i></a>
                                        @endif
                                        @if($professor->site)
                                        <a href="{{$professor->site}}" target="_blank"
                                           class="btn btn-light"><i class="fas fa-globe"></i></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card">
                                    <ul class="list-group list-group-fit">
                                        <li class="list-group-item">
                                            <div class="media align-items-center">
                                                <div class="media-left">
                                                    <i class="material-icons text-muted-light">assessment</i>
                                                </div>
                                                <div class="media-body">
                                                    Duração Total
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="media align-items-center">
                                                <div class="media-left">
                                                    <i class="material-icons text-muted-light">schedule</i>
                                                </div>
                                                <div class="media-body">
                                                    {{ app(App\Services\Services::class)->minuto_hora( $total_minuto ) }}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Avaliação</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="rating">
                                            <i class="material-icons">star</i>
                                            <i class="material-icons">star</i>
                                            <i class="material-icons">star</i>
                                            <i class="material-icons">star</i>
                                            <i class="material-icons">star_border</i>
                                        </div>
                                        <small class="text-muted">20 ratings</small>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Final do Tabs -->

        </div>

    </div>

@endsection

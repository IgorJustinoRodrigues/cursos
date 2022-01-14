@extends('template.admin')
@section('title', 'Aulas')
@section('menu-aula', 'true')

@section('header')
    <link type="text/css" href="{{ URL::asset('template/css/quill.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('template/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('footer')
    <!-- Quill -->
    <script src="{{ URL::asset('template/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        function tipoAula() {
            var tipo = $("#tipo").val();

            $(".div-ocultar").addClass('d-none');
            $("#video").addClass('d-none');

            switch (tipo) {
                case '1':
                    $(".video").removeClass('d-none')
                    $("#video").removeClass('d-none');
                    break;

                case '2':
                    $(".texto").removeClass('d-none')

                    break;
                case '3':
                    $(".pergunta").removeClass('d-none')

                    break;
            }
        }

        function player() {
            var div = $("#video").val();

            $("#player").html(div);
        }
        addPergunta()

        function addPergunta() {
            var div = '';

            div += '<div style="border: 1px dashed#000; padding: 20px">';
            div += '<div class="row">';
            div += '<div class="col-md-9">';
            div += '<label class="form-label">Pergunta #01</label>';
            div += '<input type="text" class="form-control" id="pergunta" name="pergunta[]"';
            div += '</div>';
            div += '<div class="col-md-3">';
            div += '<label class="form-label" for="status">-</label>';
            div += '<a class="btn btn-danger btn-wide btn-block">DELETAR PERGUNTA</a>';
            div += '</div>';
            div += '</div>';
            div += '<div class="div-resposta">';
            div += '<div class="row">';
            div += '<div class="col-3">';
            div += '<label class="form-label" for="status">-</label>';
            div += '<select id="status" class="form-control custom-select" name="opcao[]">';
            div += '<option value="1">Correta</option>';
            div += '<option value="0">Incorreta</option>';
            div += '</select>';
            div += '</div>';
            div += '<div class="col-8">';
            div += '<label class="form-label" for="status">-</label>';
            div += '<input type="text" class="form-control" id="pergunta"';
            div += 'name="resposta[]" value="{{ old('pergunta') }}">';
            div += '</div>';
            div += '<div class="col-1">';
            div += '<label class="form-label" for="status">-</label>';
            div += '<a class="btn btn-danger btn-wide btn-block">DELETAR</a>';
            div += '</div>';
            div += '</div>';
            div += '</div>';
            div += '<a class="btn btn-primary btn-sm mt-4 right" onclick="addResposta()">NOVA';
            div += 'RESPOSTA</a>';
            div += '</div>';

            $("#div-pergunta").append(div);
        }

        tipoAula();
    </script>
    <script src="{{ URL::asset('template/vendor/quill.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/quill.js') }}"></script>
@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Cadastro de Aula</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('aulaInserir', $curso) }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="tipo">Tipo de Aula</label>
                                <select id="tipo" class="form-control custom-select" name="tipo" onchange="tipoAula();">
                                    <option @if (old('tipo') == 1) selected @endif value="1">Aula de Vídeo</option>
                                    <option @if (old('tipo') == 2) selected @endif value="2">Aula de Texto</option>
                                    <option @if (old('tipo') == 3) selected @endif value="3">Quiz</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ old('nome') }}" required>
                            </div>
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="descricao">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao"
                                    placeholder="Descrição da aula" rows="3">{{ old('descricao') }}</textarea>
                            </div>
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="duracao">Duração da Aula (Minutos)</label>
                                <input type="number" min="1" step="1" class="form-control" id="duracao" name="duracao"
                                    placeholder="" value="{{ old('duracao') }}">
                            </div>
                            <div class="col-12 col-md-12 mb-3 div-ocultar video">
                                <label class="form-label" for="video">Link do vídeo</label>
                                <input type="url" class="form-control" id="video" name="video" placeholder="Link"
                                    onchange="player()" value="{{ old('video') }}">
                                <hr>
                                <div id="player"></div>
                            </div>
                            <div class="col-12 col-md-12 mb-3 div-ocultar texto">
                                <label class="form-label">Texto</label>
                                <div class="form-control" id="sobre" data-toggle="quill" style="height: 350px;"></div>
                            </div>

                            <div class="col-12 mb-3 div-ocultar pergunta">
                                <hr>
                                <div id="div-pergunta">
                                    <div style="border: 1px dashed#000; padding: 20px">
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="form-label">Pergunta #01</label>
                                                <input type="text" class="form-control" id="pergunta" name="pergunta[]"
                                                    value="{{ old('pergunta') }}">
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label" for="status">-</label>
                                                <a class="btn btn-danger btn-wide btn-block">DELETAR PERGUNTA</a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="div-resposta">
                                            <div class="row">
                                                <div class="col-3">
                                                    <label class="form-label" for="status">-</label>
                                                    <select id="status" class="form-control custom-select" name="opcao[]">
                                                        <option value="1">Correta</option>
                                                        <option value="0">Incorreta</option>
                                                    </select>
                                                </div>
                                                <div class="col-8">
                                                    <label class="form-label" for="status">-</label>
                                                    <input type="text" class="form-control" id="pergunta"
                                                        name="resposta[]" value="{{ old('pergunta') }}">
                                                </div>
                                                <div class="col-1">
                                                    <label class="form-label" for="status">-</label>
                                                    <a class="btn btn-danger btn-wide btn-block">DELETAR</a>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="btn btn-primary btn-sm mt-4 right" onclick="addResposta()">NOVA
                                            RESPOSTA</a>
                                    </div>
                                    <div style="border: 1px dashed#000; padding: 20px">
                                        <div class="row">
                                            <div class="col-9">
                                                <label class="form-label">Pergunta #01</label>
                                                <input type="text" class="form-control" id="pergunta" name="pergunta[]"
                                                    value="{{ old('pergunta') }}">
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label" for="status">-</label>
                                                <a class="btn btn-danger btn-wide btn-block">DELETAR PERGUNTA</a>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="div-resposta">
                                            <div class="row">
                                                <div class="col-3">
                                                    <label class="form-label" for="status">-</label>
                                                    <select id="status" class="form-control custom-select" name="opcao[]">
                                                        <option value="1">Correta</option>
                                                        <option value="0">Incorreta</option>
                                                    </select>
                                                </div>
                                                <div class="col-8">
                                                    <label class="form-label" for="status">-</label>
                                                    <input type="text" class="form-control" id="pergunta"
                                                        name="resposta[]" value="{{ old('pergunta') }}">
                                                </div>
                                                <div class="col-1">
                                                    <label class="form-label" for="status">-</label>
                                                    <a class="btn btn-danger btn-wide btn-block">DELETAR</a>
                                                </div>
                                            </div>
                                        </div>
                                        <a class="btn btn-primary btn-sm mt-4 right" onclick="addResposta()">NOVA
                                            RESPOSTA</a>
                                    </div>
                                </div>
                                <a class="btn btn-primary mt-4 right" onclick="addPergunta()">NOVA PERGUNTA</a>
                                <hr>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="status">Status</label>
                                <select id="status" class="form-control custom-select" name="status">
                                    <option @if (old('status') == 1) selected @endif value="1">Ativo</option>
                                    <option @if (old('status') == 2) selected @endif value="2">Inativo</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <div class="flex">
                                <a href="{{ route('aulaIndex', [$curso]) }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Inserir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

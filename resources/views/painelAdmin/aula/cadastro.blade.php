@extends('template.admin')
@section('title', 'Aulas')
@section('menu-aula', 'true')

@section('header')
    <link type="text/css" href="{{ URL::asset('template/css/quill.css') }}" rel="stylesheet">
@endsection

@section('footer')
    <script>
        function tipoAula() {
            var tipo = $("#tipo").val();

            $(".div-ocultar").addClass('d-none');
            $("#video").addClass('d-none');

            if(tipo == '3'){
                $(".pergunta").removeClass('d-none')
            }
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
                                    <option value="1" @if(old('tipo') == 1) selected @endif>Aula de Vídeo</option>
                                    <option value="2" @if(old('tipo') == 2) selected @endif>Aula de Texto</option>
                                    <option value="3" @if(old('tipo') == 3) selected @endif>Quiz</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 mb-3 div-ocultar pergunta">
                                <label class="form-label" for="avaliacao">Aula avaliativa?</label>
                                <select id="avaliacao" class="form-control custom-select" name="avaliacao">
                                    <option value="0" @if(old('avaliacao') == 0) selected @endif>Não</option>
                                    <option value="1" @if(old('avaliacao') == 1) selected @endif>Sim</option>
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
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="duracao">Duração da Aula (Minutos)</label>
                                <input type="number" min="1" step="1" class="form-control" id="duracao" name="duracao"
                                    placeholder="" value="{{ old('duracao') }}" required>
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

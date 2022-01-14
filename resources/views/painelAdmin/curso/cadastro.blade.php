@extends('template.admin')
@section('title', 'Cursos')
@section('menu-curso', 'true')

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
    </script>
    <script src="{{ URL::asset('template/vendor/quill.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/quill.js') }}"></script>
@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Cadastro de Curso</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('cursoInserir') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ old('nome') }}" required>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="professor">Professor</label>
                                <select id="professor" class="form-control custom-select select2" name="professor" required>
                                    <option></option>
                                    @foreach ($professor as $item)
                                        <option @if (old('professor') == $item->id) selected @endif value="{{ $item->id }}">{{ $item->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="categoria">Categoria</label>
                                <select id="categoria" class="form-control custom-select select2" name="categoria" required>
                                    <option></option>
                                    @foreach ($categoria as $item)
                                        <option @if (old('categoria') == $item->id) selected @endif value="{{ $item->id }}">{{ $item->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="tipo">Nível do Curso</label>
                                <select id="tipo" class="form-control custom-select" name="tipo">
                                    <option @if (old('tipo') == 1) selected @endif value="1">Curso Iniciante | Até 5 Aulas | R$ 18,00
                                    </option>
                                    <option @if (old('tipo') == 2) selected @endif value="2">Curso Intermediário | Até 10 Aulas | R$ 26,00
                                    </option>
                                    <option @if (old('tipo') == 3) selected @endif value="3">Curso Avançado | Mais de 15 Aulas | R$ 38,00
                                    </option>
                                    <option @if (old('tipo') == 4) selected @endif value="4">Treinamento</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="visibilidade">Visibilidade</label>
                                <select id="visibilidade" class="form-control custom-select" name="visibilidade">
                                    <option @if (old('visibilidade') == 1) selected @endif value="1">Visível</option>
                                    <option @if (old('visibilidade') == 2) selected @endif value="2">Não Visível</option>
                                </select>
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
                                <a href="{{ route('cursoIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Inserir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

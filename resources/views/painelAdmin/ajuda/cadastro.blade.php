@extends('template.admin')
@section('title', 'Ajuda')
@section('menu-ajuda', 'true')

@section('header')
    <link type="text/css" href="{{ URL::asset('template/css/quill.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('template/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('footer')
    <script>
        function prepararSubmit() {
            var texto = $(".ql-editor").html();
            $("#input-texto").val(texto);

            return true;
        }
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script src="{{ URL::asset('template/vendor/quill.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/quill.js') }}"></script>
    <script src="{{ URL::asset('template/js/select2.min.js') }}"></script>
@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Cadastro de Ajuda</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('ajudaInserir') }}" onsubmit="return prepararSubmit();">
                        @csrf
                        <input type="hidden" name="texto" id="input-texto">
                        <div class="form-row">
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ old('nome') }}" required="">
                            </div>
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label">Texto</label>
                                <div class="form-control" id="texto" data-toggle="quill" style="height: 150px;"></div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="local">Local</label>
                                <select id="local" class="form-control custom-select" name="local">
                                    <option @if (old('local') == 1) selected @endif value="1">
                                        {{ app(App\Http\Controllers\AjudaController::class)->local(1) }}</option>
                                    <option @if (old('local') == 2) selected @endif value="2">
                                        {{ app(App\Http\Controllers\AjudaController::class)->local(2) }}</option>
                                    <option @if (old('local') == 3) selected @endif value="3">
                                        {{ app(App\Http\Controllers\AjudaController::class)->local(3) }}</option>
                                    <option @if (old('local') == 4) selected @endif value="4">
                                        {{ app(App\Http\Controllers\AjudaController::class)->local(4) }}</option>
                                    <option @if (old('local') == 5) selected @endif value="5">
                                        {{ app(App\Http\Controllers\AjudaController::class)->local(5) }}</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="categoria_id">Categoria</label>
                                <select id="categoria_id" class="form-control custom-select select2" name="categoria_id">
                                    @foreach ($categorias as $linha)
                                        <option @if (old('categoria_id') == $linha->id) selected @endif value="{{ $linha->id }}">{{ $linha->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
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
                                <a href="{{ route('ajudaIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Inserir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

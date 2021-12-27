@extends('template.admin')
@section('title', 'Parceiros')
@section('menu-parceiro', 'true')

@section('header')
    <link type="text/css" href="{{ URL::asset('template/css/quill.css') }}" rel="stylesheet">
@endsection

@section('footer')
    <!-- Quill -->
    <script src="{{ URL::asset('template/vendor/quill.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/quill.js') }}"></script>
@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Cadastro de Parceiro</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('parceiroInserir') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-12 col-md-8 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ old('nome') }}" required="">
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="logo">Logo (900x600px)</label>
                                <input type="file" class="form-control" id="logo" name="logo">
                            </div>

                            <div class="col-6 col-md-6 mb-3">
                                <label class="form-label" for="usuario">Usuário</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário"
                                    value="{{ old('usuario') }}" required="">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="senha">Senha</label>
                                <input type="text" class="form-control" id="senha" value="123456" readonly>
                            </div>
                            <!-- deixar para o Igor me mostrar -->
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label">Sobre</label>
                                <div class="form-control" id="sobre" name="sobre" data-toggle="quill"
                                style="height: 150px;"></div>
                            </div>


                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="status">Status</label>
                                <select id="status" class="form-control custom-select" name="status">
                                    <option @if (old('status') == 1) selected @endif value="1">Ativo</option>
                                    <option @if (old('status') == 2) selected @endif value="2">Inativo</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="visibilidade">Visibilidade</label>
                                <select id="visibilidade" class="form-control custom-select" name="visibilidade">
                                    <option @if (old('visibilidade') == 1) selected @endif value="1">Visível</option>
                                    <option @if (old('visibilidade') == 2) selected @endif value="2">Não Visível</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <div class="flex">
                                <a href="{{ route('parceiroIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Inserir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

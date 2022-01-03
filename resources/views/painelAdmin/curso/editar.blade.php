@extends('template.admin')
@section('title', 'Parceiros')
@section('menu-parceiro', 'true')


@section('header')
    <link type="text/css" href="{{ URL::asset('template/css/quill.css') }}" rel="stylesheet">
    <!-- Touchspin -->
    <link rel="stylesheet" href="{{ URL::asset('template/css/bootstrap-touchspin.css') }}">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ URL::asset('template/css/nestable.css') }}">
@endsection

@section('footer')

    <!-- Vendor JS -->
    <script src="{{ URL::asset('template/vendor/jquery.nestable.js') }}"></script>
    <script src="{{ URL::asset('template/vendor/jquery.bootstrap-touchspin.js') }}"></script>

    <!-- Initialize -->
    <script src="{{ URL::asset('template/js/nestable.js') }}"></script>
    <script src="{{ URL::asset('template/js/touchspin.js') }}"></script>
    <script>
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
            <h1 class="h2 flex mr-3 mb-0">Edição de Parceiro</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('parceiroSalvar', $item) }}" onsubmit="return prepararSubmit();"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id" value="{{ $item->id }}">
                        <input type="hidden" name="sobre" id="input-sobre">
                        <div class="form-row">
                            <div class="col-9 col-md-11 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ $item->nome }}" required="">
                            </div>
                            <div class="col-3 col-md-1 mb-3">
                                @if ($item->logo != '')
                                    <img src="{{ URL::asset('storage/' . $item->logo) }}" alt="" class="avatar-img">
                                @else
                                    <img src="{{ URL::asset('storage/logoParceiro/padrao.png') }}" alt=""
                                        class="avatar-img">
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="logo">Logo</label>
                                <input type="file" class="form-control" id="logo" name="logo">
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="usuario">Usuário</label>
                                <input type="usuario" class="form-control" id="usuario" onchange="validaUsuario()"
                                    name="usuario" placeholder="Usuário" value="{{ $item->usuario }}" required="">
                                <small id="retorno-usuario" class="form-text"></small>
                            </div>
                            <!-- deixar para o Igor me mostrar -->
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label">Sobre</label>
                                <div class="form-control" id="sobre" data-toggle="quill" style="height: 150px;">
                                    {!! $item->sobre !!}</div>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="status">Status</label>
                                <select id="status" class="form-control custom-select" name="status">
                                    <option @if ($item->status == 1) selected @endif value="1">Ativo</option>
                                    <option @if ($item->status == 2) selected @endif value="2">Inativo</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="visibilidade">Visibilidade</label>
                                <select id="visibilidade" class="form-control custom-select" name="visibilidade">
                                    <option @if ($item->visibilidade == 1) selected @endif value="1">Visível</option>
                                    <option @if ($item->visibilidade == 2) selected @endif value="2">Não Visível</option>
                                </select>
                            </div>

                        </div>
                        <hr>
                        <div class="d-flex">
                            <div class="flex">
                                <a href="{{ route('parceiroIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Salvar</button>
                        </div>
                    </form>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Questions</h4>
                        </div>
                        <div class="card-header">
                            <a href="#" data-toggle="modal" data-target="#editQuiz" class="btn btn-outline-secondary">Add
                                Question <i class="material-icons">add</i></a>
                        </div>
                        <div class="nestable" id="nestable">
                            <ul class="list-group list-group-fit nestable-list-plain mb-0">
                                <li class="list-group-item nestable-item" data-id="1" data-ordem="1">
                                    <div class="media align-items-center">
                                        <div class="media-left">
                                            <a href="#" class="btn btn-default nestable-handle"><i
                                                    class="material-icons">menu</i></a>
                                        </div>
                                        <div class="media-body">
                                            <small id="aula1">1.</small> Introdução
                                        </div>
                                        <div class="media-right text-right">
                                            <div style="width:100px">
                                                <a href="#" data-toggle="modal" data-target="#editQuiz"
                                                    class="btn btn-primary btn-sm"><i class="material-icons">edit</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item nestable-item" data-id="2" data-ordem="2">
                                    <div class="media align-items-center">
                                        <div class="media-left">
                                            <a href="#" class="btn btn-default nestable-handle"><i
                                                    class="material-icons">menu</i></a>
                                        </div>
                                        <div class="media-body">
                                            <small id="aula2">2.</small> Menu
                                        </div>
                                        <div class="media-right text-right">
                                            <div style="width:100px">
                                                <a href="#" data-toggle="modal" data-target="#editQuiz"
                                                    class="btn btn-primary btn-sm"><i class="material-icons">edit</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item nestable-item" data-id="3" data-ordem="3">
                                    <div class="media align-items-center">
                                        <div class="media-left">
                                            <a href="#" class="btn btn-default nestable-handle"><i
                                                    class="material-icons">menu</i></a>
                                        </div>
                                        <div class="media-body">
                                            <small id="aula3">3.</small> Criar Pasta
                                        </div>
                                        <div class="media-right text-right">
                                            <div style="width:100px">
                                                <a href="#" data-toggle="modal" data-target="#editQuiz"
                                                    class="btn btn-primary btn-sm"><i class="material-icons">edit</i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

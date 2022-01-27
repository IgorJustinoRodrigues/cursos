@extends('template.unidade')
@section('title', 'Painel de Unidade')
@section('menu-unidade', 'true')


@section('header')
    <link type="text/css" href="{{ URL::asset('template/css/quill.css') }}" rel="stylesheet">
@endsection
@section('footer')
    <!-- Global Settings -->
    <script src="{{ URL::asset('template/js/settings.js') }}"></script>

    <!-- Moment.js -->
    <script src="{{ URL::asset('template/vendor/moment.min.js') }}"></script>
    <script src="{{ URL::asset('template/vendor/moment-range.js') }}"></script>

    <!-- Quill -->
    <script src="{{ URL::asset('template/vendor/quill.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/quill.js') }}"></script>

    <!-- jQuery Mask Plugin -->
    <script src="{{ URL::asset('template/vendor/jquery.mask.min.js') }}"></script>
    <script>
        function prepararSubmit() {
            var sobre = $(".ql-editor").html();
            $("#input-sobre").val(sobre);

            return true;
        }

        $('.cpf').mask('000.000.000-00');

        function addMask(id) {
            var quant = $("#" + id).cleanVal().length;
            if (quant > 10) {
                $("#" + id).mask('(00) 0 0000-0000');
            } else {
                $("#" + id).mask('(00) 0000-00000');
            }
        }

        $(".senha2").addClass('d-none');

        function verificaSenha() {
            var senha = $("#senha").val();
            var senha2 = $("#senha2").val();

            if (senha == '' && senha2 == '') {
                $("#msg-senha").text("");
                $('#senha-status').text("");

                $('#btn-salvar').attr('disabled', false);
                return null;
            }

            $('#btn-salvar').attr('disabled', true);

            var verifica = 3 * (senha.length / 4);

            if (senha2.length > verifica) {
                if (senha == senha2) {
                    if (senha.length < 6) {
                        $('#btn-salvar').attr('disabled', true);
                    } else {
                        $('#btn-salvar').attr('disabled', false);
                    }
                    $("#msg-senha").html("<span style='color:green'>Senhas iguais</span>");
                } else {
                    $("#msg-senha").html("<span style='color:red'>As senhas são diferentes</span>");
                }
            }
        }

        function verificaForcaSenha() {
            var numeros = /([0-9])/;
            var alfabeto = /([a-zA-Z])/;

            if ($('#senha').val().length < 6) {
                $('#senha-status').html("<span style='color:red'>Senha fraca, insira no mínimo 6 caracteres</span>");
                $("#senha2").val('');
                $(".senha2").addClass('d-none');
                $('#btn-salvar').attr('disabled', true);
            } else {
                $(".senha2").removeClass('d-none');
                if ($('#senha').val().match(numeros) && $('#senha').val().match(alfabeto)) {
                    $('#senha-status').html("<span style='color:green'><b>Senha forte</b></span>");
                } else {
                    $('#senha-status').html("<span style='color:orange'>Senha médio</span>");
                }
            }
        }

        function validaUsuario() {
            var usuario = $("#usuario").val();
            var id = $("#id").val();

            if (usuario == '') {
                $("#retorno-usuario").text('');
                return null;
            }

            $.ajax({
                type: 'post',
                url: "{{ route('validaUsuarioUnidade') }}",
                data: {
                    usuario: usuario,
                    id: id,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#retorno-usuario").text('Consultado...');
                },
                success: function(data) {
                    if (data.status == '1') {
                        $("#retorno-usuario").removeClass('text-success');
                        $("#retorno-usuario").removeClass('text-danger');
                        $("#retorno-usuario").removeClass('text-primary');

                        if (data.tipo == 1) {
                            $("#retorno-usuario").addClass('text-success');
                        } else if (data.tipo == 2) {
                            $("#retorno-usuario").addClass('text-danger');
                            $("#usuario").val('');
                        } else {
                            $("#retorno-usuario").addClass('text-primary');
                        }

                        $("#retorno-usuario").text(data.msg);
                    } else {
                        Lobibox.notify('warning', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: data.msg
                        });
                        $("#retorno-usuario").text('');
                        $("#usuario").val('');
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
                }
            });
        }

        validaUsuario();
    </script>
@endsection

@section('conteudo')
    <div class="container page__container p-0">
        <form action="{{ route('salvarMinhasInformacoesParceiro') }}" onsubmit="return prepararSubmit();" method="post"
            enctype="multipart/form-data" class="row m-0">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="id" value="{{ $item->id }}">
            <input type="hidden" name="sobre" id="input-sobre">
            <div class="col-lg container-fluid page__container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('painelParceiro') }}">Início</a></li>
                    <li class="breadcrumb-item active">Minha Conta</li>
                </ol>
                <h1 class="h2">{{ $item->nome }}</h1>
                <div class="card">
                    <div class="list-group list-group-fit">
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-unidade" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-unidade" for="unidade"
                                        class="col-md-12 col-form-label form-label">Minha Unidade</label>
                                    <label id="label-unidade" for="unidade" class="col-md-12 col-form-label form-label">
                                        <h3>{{ $item->unidade }}</h3>
                                    </label>

                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-logo" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-logo" for="logo"
                                        class="col-md-2 col-form-label form-label">Foto</label>
                                    <div class="col-md-10">
                                        <div class="media align-items-center">
                                            <div class="d-flex mr-3 align-self-center">
                                                <span class="logo logo-lg">
                                                    @if ($item->logo != '')
                                                        <img src="{{ URL::asset('storage/' . $item->logo) }}"
                                                            alt="logo" class="w-100">
                                                    @else
                                                        <img src="{{ URL::asset('storage/logoParceiro/padrao.png') }}"
                                                            alt="logo" class="w-100">
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <div class="custom-file b-form-file">
                                                    <input type="file" id="logo" aria-describedby="label-logo-control"
                                                        class="custom-file-input" name="logo">
                                                    <label id="label-logo-control" class="custom-file-label">Envie uma
                                                        logo sua</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-nome" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-nome" for="nome"
                                        class="col-md-2 col-form-label form-label">Nome</label>
                                    <div class="col-md-10">
                                        <input type="text" id="nome" placeholder="Informe o seu nome" class="form-control"
                                            name="nome" value="{{ $item->nome }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-usuario" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-usuario" for="usuario"
                                        class="col-md-2 col-form-label form-label">Usuário</label>
                                    <div class="col-md-10">
                                        <input type="text" id="usuario" value="{{ $item->usuario }}"
                                            onchange="validaUsuario()" name="usuario" class="form-control" />
                                        <small id="retorno-usuario" class="form-text"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-senha" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-senha" for="senha" class="col-md-2 col-form-label form-label">Editar
                                        Senha</label>
                                    <div class="col-md-4">
                                        <input type="password" id="senha" name="senha" class="form-control"
                                            onkeyup=" verificaForcaSenha(); verificaSenha();" />
                                        <div id="senha-status"></div>
                                    </div>
                                    <div class="col-md-6 row senha2">
                                        <label id="label-senha2" for="senha2"
                                            class="col-md-4 col-form-label form-label text-right">Confirmar Senha</label>
                                        <div class="col-md-8">
                                            <input type="password" id="senha2" name="senha2" class="form-control"
                                                onkeyup="verificaSenha()" />
                                            <div id="msg-senha"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-sobre" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-sobre" for="sobre"
                                        class="col-md-2 col-form-label form-label">Sobre</label>
                                    <div class="col-md-10">
                                        <div class="form-control" id="sobre" data-toggle="quill" style="height: 150px;">
                                            {!! $item->sobre !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div id="page-nav" class="col-lg-auto page-nav">
                <div data-perfect-scrollbar="" class="ps">
                    <div class="page-section pt-lg-32pt">
                        <ul class="nav page-nav__menu">
                            <li class="nav-item">
                                <a href="fixed-student-account-edit-profile.html" class="nav-link active">Minha
                                    Conta</a>
                            </li>
                        </ul>
                        <div class="page-nav__content">
                            <button class="btn btn-success" id="btn-salvar">Salvar Alterações</button>
                        </div>
                    </div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

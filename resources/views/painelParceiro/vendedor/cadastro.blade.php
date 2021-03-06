@extends('template.parceiro')
@section('title', 'Vendedor')
@section('menu-vendedor', 'true')


@section('header')
    <link href="{{ URL::asset('template/css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('footer')

    <!-- jQuery Mask Plugin -->
    <script src="{{ URL::asset('template/vendor/jquery.mask.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/select2.min.js') }}"></script>

    <script>
         $(document).ready(function() {
            $('.select2').select2();
        });

        $("#whatsapp").mask("(99) 99999-9999");

        function validaUsuario() {
            var tabela = 'vendedor';
            var usuario = $("#usuario").val();
            var id = null;

            if (usuario == '') {
                $("#retorno-usuario").text('');
                return null;
            }

            $.ajax({
                type: 'post',
                url: "{{ route('validaUsuarioParceiro') }}",
                data: {
                    usuario: usuario,
                    tabela: tabela,
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
                        msg: "O sistema est?? passando por instabilidades no momento! Tente novamente mais tarde."
                    });
                }
            });
        }
    </script>

@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Cadastro de Vendedor</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('inserirVendedorParceiro') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">

                            <div class="col-12 col-md-4">
                                <label class="form-label" for="unidade_id">Unidade</label>
                                <select id="unidade_id" class="form-control custom-select select2" name="unidade_id">
                                    <option></option>
                                    @foreach ($unidade as $item)
                                        <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-8 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ old('nome') }}" required="">
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="avatar">Avatar do Vendedor</label>
                                <input type="file" class="form-control" id="avatar" name="avatar">
                            </div>
                            <div class="col-6 col-md-4 mb-3">
                                <label class="form-label" for="usuario">Usu??rio</label>
                                <input type="text" class="form-control" onchange="validaUsuario()" id="usuario" name="usuario"  placeholder="Usu??rio"
                                    value="{{ old('usuario') }}" required="">
                                <small id="retorno-usuario" class="form-text"></small>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="******"
                                    required>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="cpf">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf"
                                    placeholder="CPF" value="{{ old('cpf') }}">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="whatsapp">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                    placeholder="WhatsApp" value="{{ old('whatsapp') }}">
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
                                <a href="{{ route('vendedorIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Inserir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

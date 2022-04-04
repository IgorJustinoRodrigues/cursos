@extends('template.unidade')
@section('title', 'Unidade')
@section('menu-vendedor', 'true')

@section('footer')
    <!-- jQuery Mask Plugin -->
    <script src="{{ URL::asset('template/vendor/jquery.mask.min.js') }}"></script>
    <script>
        $("#whatsapp").mask("(99) 99999-9999");

        function validaUsuario() {
            var tabela = 'vendedor';
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
                        msg: "O sistema está passando por instabilidades no momento! Tente novamente mais tarde."
                    });
                }
            });
        }

        validaUsuario();
    </script>

@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Edição de Vendedor</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('salvarVendedorUnidade', $item) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id" value="{{ $item->id }}">
                        <div class="form-row">
                            <div class="col-9 col-md-11 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ $item->nome }}" required="">
                            </div>
                            <div class="col-3 col-md-1 mb-3">
                                @if ($item->avatar != '')
                                    <img src="{{ URL::asset('storage/' . $item->avatar) }}" alt="" class="avatar-img">
                                @else
                                    <img src="{{ URL::asset('storage/avatarVendedor/padrao.png') }}" alt=""
                                        class="avatar-img">
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="avatar">Avatar do Vendedor</label>
                                <input type="file" class="form-control" id="avatar" name="avatar">
                            </div>

                            <div class="col-9 col-md-4 mb-3">
                                <label class="form-label" for="usuario">Usuário</label>
                                <input type="text" class="form-control" onchange="validaUsuario()" id="usuario"
                                    name="usuario" placeholder="Usuário" value="{{ $item->usuario }}" required="">
                                <small id="retorno-usuario" class="form-text"></small>
                            </div>
                            <div class="col-9 col-md-4 mb-3">
                                <label class="form-label" for="senha">senha</label>
                                <input type="password" class="form-control" id="senha" minlength="6" name="senha"
                                    placeholder="********">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="cpf">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF"
                                    value="{{ $item->cpf }}">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail"
                                    value="{{ $item->email }}">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="whatsapp">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                    placeholder="WhatsApp" value="{{ $item->whatsapp }}">
                            </div>

                            <div class="col-12 col-md-4 mb-3">
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
                                <a href="{{ route('indexVendedorUnidade') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

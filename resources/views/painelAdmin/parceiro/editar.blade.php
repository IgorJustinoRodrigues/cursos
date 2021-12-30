@extends('template.admin')
@section('title', 'Parceiros')
@section('menu-parceiro', 'true')


@section('header')
    <link type="text/css" href="{{ URL::asset('template/css/quill.css') }}" rel="stylesheet">
@endsection

@section('footer')
    <script>
        function prepararSubmit() {
            var sobre = $(".ql-editor").html();
            $("#input-sobre").val(sobre);

            return true;
        }

        function validaUsuario() {
            var tabela = 'parceiro';
            var usuario = $("#usuario").val();
            var id = $("#id").val();
            
            if(usuario == ''){
                $("#retorno-usuario").text('');
                return null;
            }

            $.ajax({
                type: 'post',
                url: "{{ route('adminValidaUsuario') }}",
                data: {
                    usuario: usuario,
                    tabela: tabela,
                    id: id,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    //Aguardando
                },
                success: function(data) {
                    if (data.status == '1') {
                        $("#retorno-usuario").removeClass('text-success');
                        $("#retorno-usuario").removeClass('text-danger');
                        $("#retorno-usuario").removeClass('text-primary');
                        
                        if(data.tipo == 1){
                            $("#retorno-usuario").addClass('text-success');
                        } else if(data.tipo == 2){
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
    <!-- Quill -->
    <script src="{{ URL::asset('template/vendor/quill.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/quill.js') }}"></script>
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
                                <input type="usuario" class="form-control" id="usuario" onchange="validaUsuario()" name="usuario"
                                    placeholder="Usuário" value="{{ $item->usuario }}" required="">
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
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('template.admin')
@section('title', 'Administradores')
@section('menu-admin', 'true')

@section('footer')
<script>    
    function validaUsuario() {
        var tabela = 'administrador';
        var usuario = $("#email").val();
        var id = null;
        
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
                $("#retorno-usuario").text('Consultado...');
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
                        $("#email").val('');
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
                    $("#email").val('');
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
</script>
@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Cadastro de Administrador</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('adminInserir') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ old('nome') }}" required="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="avatar">Avatar</label>
                                <input type="file" class="form-control" id="avatar" name="avatar">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="tipo">Tipo</label>
                                <select id="tipo" class="form-control custom-select" name="tipo">
                                    <option @if (old('tipo') == 1) selected @endif value="1">Administração</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" onchange="validaUsuario()" name="email" placeholder="E-mail"
                                    value="{{ old('email') }}" required="">
                                <small id="retorno-usuario" class="form-text"></small>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="******" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="anotacoes">Anotações</label>
                                <textarea class="form-control" id="anotacoes" placeholder="Anotações" name="anotacoes"
                                    rows="3">{{ old('anotacoes') }}</textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <div class="flex">
                                <a href="{{ route('adminIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Inserir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('template.admin')
@section('title', 'Aluno')
@section('menu-aluno', 'true')

@section('footer')

    <!-- jQuery Mask Plugin -->
    <script src="{{ URL::asset('template/vendor/jquery.mask.min.js') }}"></script>
    <script>
        $("#whatsapp").mask("(99) 99999-9999");

        function validaUsuario() {
            var tabela = 'aluno';
            var usuario = $("#usuario").val();
            var id = null;

            if (usuario == '') {
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
    </script>

@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Cadastro de Aluno</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('alunoInserir') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">

                            <div class="col-12 col-md-8 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ old('nome') }}" required="">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="avatar">Avatar</label>
                                <input type="file" class="form-control" id="avatar" name="avatar">
                            </div>
                            <div class="col-6 col-md-4 mb-3">
                                <label class="form-label" for="usuario">Usuário</label>
                                <input type="text" class="form-control" onchange="validaUsuario()" id="usuario"
                                    name="usuario" placeholder="Usuário" value="{{ old('usuario') }}" required="">
                                <small id="retorno-usuario" class="form-text"></small>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label class="form-label" for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="******"
                                    required>
                            </div>
                            <div class="col-12 col-md-5 mb-3">
                                <label class="form-label" for="nascimento">Data de Nascimento</label>
                                <input type="date" class="form-control" id="nascimento" name="nascimento"
                                    value="{{ old('nascimento') }}" required="">
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="sexo">Sexo</label>
                                <select id="sexo" class="form-control custom-select" name="sexo">
                                    <option @if (old('sexo') == 1) selected @endif value="1">Masculino</option>
                                    <option @if (old('sexo') == 2) selected @endif value="2">Feminino</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="cpf">Cpf do Aluno</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF"
                                    value="{{ old('cpf') }}">
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="rg">Rg do Aluno</label>
                                <input type="text" class="form-control" id="rg" name="rg" placeholder="RG"
                                    value="{{ old('rg') }}">
                            </div>

                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="nome_responsavel">Nome do Responsável</label>
                                <input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel"
                                    placeholder="Nome" value="{{ old('nome_responsavel') }}" >
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="cpf_responsavel">Cpf do Responsável</label>
                                <input type="text" class="form-control" id="cpf_responsavel" name="cpf_responsavel"
                                    placeholder="Cpf do Responsavel" value="{{ old('cpf_responsavel') }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="rg_responsavel">Rg do Responsável</label>
                                <input type="text" class="form-control" id="rg_responsavel" name="rg_responsavel"
                                    placeholder="Rg do Responsavel" value="{{ old('rg_responsavel') }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label class="form-label" for="whatsapp">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                    placeholder="WhatsApp" value="{{ old('whatsapp') }}">
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label class="form-label" for="telefone">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone"
                                    placeholder="Telefone" value="{{ old('telefone') }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="contato">Contato</label>
                                <textarea class="form-control" id="contato" placeholder="Contato" name="contato"
                                    rows="3">{{ old('contato') }}</textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="endereco">Endereço</label>
                                <textarea class="form-control" id="endereco" placeholder="Endereço" name="endereco"
                                    rows="3">{{ old('endereco') }}</textarea>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="cidade">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade"
                                    value="{{ old('cidade') }}">
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="estado">Estado</label>
                                <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado"
                                    value="{{ old('estado') }}">
                            </div>

                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="pontuacao">Pontuação</label>
                                <input type="number" class="form-control" id="pontuacao" name="pontuacao" placeholder="Pontuação"
                                    value="{{ old('pontuacao') }}">
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
                                <a href="{{ route('alunoIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Inserir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

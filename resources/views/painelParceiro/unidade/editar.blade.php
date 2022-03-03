@extends('template.parceiro')
@section('title', 'Unidade')
@section('menu-unidade', 'true')


@section('footer')
    <!-- jQuery Mask Plugin -->
    <script src="{{ URL::asset('template/vendor/jquery.mask.min.js') }}"></script>
    <script>
        $("#whatsapp").mask("(99) 99999-9999");

        function validaUsuario() {
            var tabela = 'unidade';
            var usuario = $("#usuario").val();
            var id = $("#id").val();

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
            <h1 class="h2 flex mr-3 mb-0">Edição de Unidade</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('salvarUnidadeParceiro', $item) }}" enctype="multipart/form-data">
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
                                @if ($item->logo != '')
                                    <img src="{{ URL::asset('storage/' . $item->logo) }}" alt="" class="avatar-img">
                                @else
                                    <img src="{{ URL::asset('storage/logoUnidade/padrao.png') }}" alt=""
                                        class="avatar-img">
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="logo">logo da Unidade</label>
                                <input type="file" class="form-control" id="logo" name="logo">
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

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail"
                                    value="{{ $item->email }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="whatsapp">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                    placeholder="WhatsApp" value="{{ $item->whatsapp }}">
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="contato">Contato</label>
                                <textarea class="form-control" id="contato" placeholder="Contato" name="contato"
                                    rows="3">{{ $item->contato }}</textarea>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label" for="endereco">Endereço</label>
                                <textarea class="form-control" id="endereco" placeholder="Contato" name="endereco"
                                    rows="3">{{ $item->endereco }}</textarea>
                            </div>

                            <div class="col-9 col-md-6 mb-3">
                                <label class="form-label" for="cidade">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade"
                                    value="{{ $item->cidade }}">
                            </div>

                            <div class="col-9 col-md-6 mb-3">
                                <label class="form-label" for="estado">Estado</label>
                                <div class="col-md-12">
                                    <select id="estado" name="estado" class="form-control">
                                        <option value="" @if ($item->estado == '') selected @endif>-</option>
                                        <option value="AC" @if ($item->estado == 'AC') selected @endif>Acre</option>
                                        <option value="AL" @if ($item->estado == 'AL') selected @endif>Alagoas
                                        </option>
                                        <option value="AP" @if ($item->estado == 'AP') selected @endif>Amapá</option>
                                        <option value="AM" @if ($item->estado == 'AM') selected @endif>Amazonas
                                        </option>
                                        <option value="BA" @if ($item->estado == 'BA') selected @endif>Bahia</option>
                                        <option value="CE" @if ($item->estado == 'CE') selected @endif>Ceará</option>
                                        <option value="DF" @if ($item->estado == 'DF') selected @endif>Distrito
                                            Federal</option>
                                        <option value="ES" @if ($item->estado == 'ES') selected @endif>Espírito Santo
                                        </option>
                                        <option value="GO" @if ($item->estado == 'GO') selected @endif>Goiás</option>
                                        <option value="MA" @if ($item->estado == 'MA') selected @endif>Maranhão
                                        </option>
                                        <option value="MT" @if ($item->estado == 'MT') selected @endif>Mato Grosso
                                        </option>
                                        <option value="MS" @if ($item->estado == 'MS') selected @endif>Mato Grosso
                                            do Sul</option>
                                        <option value="MG" @if ($item->estado == 'MG') selected @endif>Minas Gerais
                                        </option>
                                        <option value="PA" @if ($item->estado == 'PA') selected @endif>Pará</option>
                                        <option value="PB" @if ($item->estado == 'PB') selected @endif>Paraíba
                                        </option>
                                        <option value="PR" @if ($item->estado == 'PR') selected @endif>Paraná
                                        </option>
                                        <option value="PE" @if ($item->estado == 'PE') selected @endif>Pernambuco
                                        </option>
                                        <option value="PI" @if ($item->estado == 'PI') selected @endif>Piauí
                                        </option>
                                        <option value="RJ" @if ($item->estado == 'RJ') selected @endif>Rio de
                                            Janeiro</option>
                                        <option value="RN" @if ($item->estado == 'RN') selected @endif>Rio Grande do
                                            Norte</option>
                                        <option value="RS" @if ($item->estado == 'RS') selected @endif>Rio Grande do
                                            Sul</option>
                                        <option value="RO" @if ($item->estado == 'RO') selected @endif>Rondônia
                                        </option>
                                        <option value="RR" @if ($item->estado == 'RR') selected @endif>Roraima
                                        </option>
                                        <option value="SC" @if ($item->estado == 'SC') selected @endif>Santa
                                            Catarina</option>
                                        <option value="SP" @if ($item->estado == 'SP') selected @endif>São Paulo
                                        </option>
                                        <option value="SE" @if ($item->estado == 'SE') selected @endif>Sergipe
                                        </option>
                                        <option value="TO" @if ($item->estado == 'TO') selected @endif>Tocantins
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="facebook">Facebook</label>
                                <input type="url" class="form-control" id="facebook" name="facebook"
                                    placeholder="URL do Facebook" value="{{ $item->facebook }}">
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="instagram">Instagram</label>
                                <input type="url" class="form-control" id="instagram" name="instagram"
                                    placeholder="URL do Instagram" value="{{ $item->instagram }}">
                            </div>

                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="site">Site</label>
                                <input type="url" class="form-control" id="site" name="site" placeholder="URL do Site"
                                    value="{{ $item->site }}">
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
                                <a href="{{ route('unidadeIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

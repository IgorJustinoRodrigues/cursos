@extends('template.admin')
@section('title', 'Unidade')
@section('menu-unidade', 'true')

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
            var tabela = 'unidade';
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
            <h1 class="h2 flex mr-3 mb-0">Cadastro de Unidade</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('unidadeInserir') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">

                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="parceiro_id">Parceiro</label>
                                <select id="parceiro_id" class="form-control custom-select select2" name="parceiro_id">
                                    <option></option>
                                    @foreach ($parceiro as $item)
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
                                <label class="form-label" for="logo">Logo da Unidade</label>
                                <input type="file" class="form-control" id="logo" name="logo">
                            </div>
                            <div class="col-6 col-md-4 mb-3">
                                <label class="form-label" for="usuario">Usuário</label>
                                <input type="text" class="form-control" onchange="validaUsuario()" id="usuario"
                                    name="usuario" placeholder="Usuário" value="{{ old('usuario') }}" required="">
                                <small id="retorno-usuario" class="form-text"></small>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <label class="form-label" for="senha">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" placeholder="******"
                                    required>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail"
                                    value="{{ old('email') }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="whatsapp">WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                    placeholder="WhatsApp" value="{{ old('whatsapp') }}">
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
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="cidade">Cidade</label>
                                <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade"
                                    value="{{ old('cidade') }}">
                            </div>


                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="cidade">Estado</label>
                                <div class="col-md-12">
                                    <select id="estado" name="estado" class="form-control">
                                        <option value="" @if (old('estado') == '') selected @endif>-</option>
                                        <option value="AC" @if (old('estado') == 'AC') selected @endif>Acre</option>
                                        <option value="AL" @if (old('estado') == 'AL') selected @endif>Alagoas</option>
                                        <option value="AP" @if (old('estado') == 'AP') selected @endif>Amapá</option>
                                        <option value="AM" @if (old('estado') == 'AM') selected @endif>Amazonas</option>
                                        <option value="BA" @if (old('estado') == 'BA') selected @endif>Bahia</option>
                                        <option value="CE" @if (old('estado') == 'CE') selected @endif>Ceará</option>
                                        <option value="DF" @if (old('estado') == 'DF') selected @endif>Distrito Federal</option>
                                        <option value="ES" @if (old('estado') == 'ES') selected @endif>Espírito Santo</option>
                                        <option value="GO" @if (old('estado') == 'GO') selected @endif>Goiás</option>
                                        <option value="MA" @if (old('estado') == 'MA') selected @endif>Maranhão</option>
                                        <option value="MT" @if (old('estado') == 'MT') selected @endif>Mato Grosso</option>
                                        <option value="MS" @if (old('estado') == 'MS') selected @endif>Mato Grosso do Sul</option>
                                        <option value="MG" @if (old('estado') == 'MG') selected @endif>Minas Gerais</option>
                                        <option value="PA" @if (old('estado') == 'PA') selected @endif>Pará</option>
                                        <option value="PB" @if (old('estado') == 'PB') selected @endif>Paraíba</option>
                                        <option value="PR" @if (old('estado') == 'PR') selected @endif>Paraná</option>
                                        <option value="PE" @if (old('estado') == 'PE') selected @endif>Pernambuco</option>
                                        <option value="PI" @if (old('estado') == 'PI') selected @endif>Piauí</option>
                                        <option value="RJ" @if (old('estado') == 'RJ') selected @endif>Rio de Janeiro</option>
                                        <option value="RN" @if (old('estado') == 'RN') selected @endif>Rio Grande do Norte</option>
                                        <option value="RS" @if (old('estado') == 'RS') selected @endif>Rio Grande do Sul</option>
                                        <option value="RO" @if (old('estado') == 'RO') selected @endif>Rondônia</option>
                                        <option value="RR" @if (old('estado') == 'RR') selected @endif>Roraima</option>
                                        <option value="SC" @if (old('estado') == 'SC') selected @endif>Santa Catarina</option>
                                        <option value="SP" @if (old('estado') == 'SP') selected @endif>São Paulo</option>
                                        <option value="SE" @if (old('estado') == 'SE') selected @endif>Sergipe</option>
                                        <option value="TO" @if (old('estado') == 'TO') selected @endif>Tocantins</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="facebook">Facebook</label>
                                <input type="url" class="form-control" id="facebook" name="facebook"
                                    placeholder="URL do Facebook" value="{{ old('facebook') }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="instagram">Instagram</label>
                                <input type="url" class="form-control" id="instagram" name="instagram"
                                    placeholder="URL do Instagram" value="{{ old('instagram') }}">
                            </div>
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="site">Site</label>
                                <input type="url" class="form-control" id="site" name="site" placeholder="URL do Site"
                                    value="{{ old('site') }}">
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
                                <a href="{{ route('unidadeIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Inserir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

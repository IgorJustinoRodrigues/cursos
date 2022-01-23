@extends('template.aluno')
@section('title', 'Painel de aluno')

@section('footer')
    <!-- Global Settings -->
    <script src="{{ URL::asset('template/js/settings.js') }}"></script>

    <!-- Moment.js -->
    <script src="{{ URL::asset('template/vendor/moment.min.js') }}"></script>
    <script src="{{ URL::asset('template/vendor/moment-range.js') }}"></script>

    <!-- jQuery Mask Plugin -->
    <script src="{{ URL::asset('template/vendor/jquery.mask.min.js') }}"></script>
    <script>
        $('.telefone').mask('(00) 0000-00000');

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
    </script>
@endsection

@section('conteudo')
    <div class="container page__container p-0">
        <form action="{{ route('salvarMinhasInformacoes') }}" method="post" enctype="multipart/form-data"
            class="row m-0">
            @csrf
            @method('PUT')
            <div class="col-lg container-fluid page__container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('painelAluno') }}">Início</a></li>
                    <li class="breadcrumb-item active">Minha Conta</li>
                </ol>
                <h1 class="h2">{{ $item->nome }}</h1>
                <div class="card">
                    <div class="list-group list-group-fit">
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-avatar" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-avatar" for="avatar"
                                        class="col-md-2 col-form-label form-label">Foto</label>
                                    <div class="col-md-10">
                                        <div class="media align-items-center">
                                            <div class="d-flex mr-3 align-self-center">
                                                <span class="avatar avatar-lg">
                                                    @if ($item->avatar != '')
                                                        <img src="{{ URL::asset('storage/' . $item->avatar) }}"
                                                            alt="Avatar" class="w-100">
                                                    @else
                                                        <img src="{{ URL::asset('storage/avatarAluno/padrao.png') }}"
                                                            alt="Avatar" class="w-100">
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="media-body">
                                                <div class="custom-file b-form-file">
                                                    <input type="file" id="avatar" aria-describedby="label-avatar-control"
                                                        class="custom-file-input" name="avatar">
                                                    <label id="label-avatar-control" class="custom-file-label">Envie uma
                                                        foto sua</label>
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
                                        <input type="text" id="nome" placeholder="Informe o seu nome" class="form-control" name="nome"
                                            value="{{ $item->nome }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-email" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-email" for="email"
                                        class="col-md-2 col-form-label form-label">E-mail</label>
                                    <div class="col-md-10">
                                        <input type="text" id="email" value="{{ $item->email }}" name="email"
                                            class="form-control" />
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
                                        <input type="text" id="senha" name="senha" class="form-control"
                                            onkeyup=" verificaForcaSenha(); verificaSenha();" />
                                        <div id="senha-status"></div>
                                    </div>
                                    <div class="col-md-6 row senha2">
                                        <label id="label-senha2" for="senha2"
                                            class="col-md-4 col-form-label form-label text-right">Confirmar Senha</label>
                                        <div class="col-md-8">
                                            <input type="text" id="senha2" name="senha2" class="form-control"
                                                onkeyup="verificaSenha()" />
                                            <div id="msg-senha"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-nascimento" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-nascimento" for="nascimento"
                                        class="col-md-2 col-form-label form-label">Data de Nascimento</label>
                                    <div class="col-md-4">
                                        <input type="date" id="nascimento" name="nascimento" placeholder="Informe o seu nascimento"
                                            class="form-control" value="{{ $item->nascimento }}">
                                    </div>
                                    <label id="label-sexo" for="sexo"
                                        class="col-md-2 col-form-label form-label text-right">Sexo</label>
                                    <div class="col-md-4">
                                        <select id="sexo" name="sexo" class="form-control">
                                            <option value="">-</option>
                                            <option value="1" @if ($item->sexo == 1) selected @endif>Masculino</option>
                                            <option value="2" @if ($item->sexo == 2) selected @endif>Feminino</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-whatsapp" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-whatsapp" for="whatsapp"
                                        class="col-md-2 col-form-label form-label">WhatsApp</label>
                                    <div class="col-md-4">
                                        <input type="text" id="whatsapp" name="whatsapp" value="{{ $item->whatsapp }}"
                                            class="form-control telefone" onkeyup="addMask('whatsapp')" />
                                    </div>
                                    <label id="label-telefone" for="telefone"
                                        class="col-md-2 col-form-label form-label text-right">Telefone</label>
                                    <div class="col-md-4">
                                        <input type="text" id="telefone" name="telefone" value="{{ $item->telefone }}"
                                            class="form-control telefone" onkeyup="addMask('telefone')" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-contato" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-contato" for="contato"
                                        class="col-md-2 col-form-label form-label">Contato Extra</label>
                                    <div class="col-md-10">
                                        <textarea id="contato" name="contato" placeholder="Contatos extras" rows="3"
                                            class="form-control">{{ $item->contato }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-cidade" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-cidade" for="cidade"
                                        class="col-md-2 col-form-label form-label">Cidade</label>
                                    <div class="col-md-5">
                                        <input type="text" id="cidade" name="cidade" placeholder="Informe sua cidade"
                                            class="form-control" value="{{ $item->cidade }}">
                                    </div>
                                    <label id="label-estado" for="estado"
                                        class="col-md-2 col-form-label form-label text-right">Estado</label>
                                    <div class="col-md-3">
                                        <select id="estado" name="estado" class="form-control">
                                            <option value="" @if ($item->estado == '') selected @endif>-</option>
                                            <option value="AC" @if ($item->estado == 'AC') selected @endif>Acre</option>
                                            <option value="AL" @if ($item->estado == 'AL') selected @endif>Alagoas</option>
                                            <option value="AP" @if ($item->estado == 'AP') selected @endif>Amapá</option>
                                            <option value="AM" @if ($item->estado == 'AM') selected @endif>Amazonas</option>
                                            <option value="BA" @if ($item->estado == 'BA') selected @endif>Bahia</option>
                                            <option value="CE" @if ($item->estado == 'CE') selected @endif>Ceará</option>
                                            <option value="DF" @if ($item->estado == 'DF') selected @endif>Distrito Federal</option>
                                            <option value="ES" @if ($item->estado == 'ES') selected @endif>Espírito Santo</option>
                                            <option value="GO" @if ($item->estado == 'GO') selected @endif>Goiás</option>
                                            <option value="MA" @if ($item->estado == 'MA') selected @endif>Maranhão</option>
                                            <option value="MT" @if ($item->estado == 'MT') selected @endif>Mato Grosso</option>
                                            <option value="MS" @if ($item->estado == 'MS') selected @endif>Mato Grosso do Sul</option>
                                            <option value="MG" @if ($item->estado == 'MG') selected @endif>Minas Gerais</option>
                                            <option value="PA" @if ($item->estado == 'PA') selected @endif>Pará</option>
                                            <option value="PB" @if ($item->estado == 'PB') selected @endif>Paraíba</option>
                                            <option value="PR" @if ($item->estado == 'PR') selected @endif>Paraná</option>
                                            <option value="PE" @if ($item->estado == 'PE') selected @endif>Pernambuco</option>
                                            <option value="PI" @if ($item->estado == 'PI') selected @endif>Piauí</option>
                                            <option value="RJ" @if ($item->estado == 'RJ') selected @endif>Rio de Janeiro</option>
                                            <option value="RN" @if ($item->estado == 'RN') selected @endif>Rio Grande do Norte</option>
                                            <option value="RS" @if ($item->estado == 'RS') selected @endif>Rio Grande do Sul</option>
                                            <option value="RO" @if ($item->estado == 'RO') selected @endif>Rondônia</option>
                                            <option value="RR" @if ($item->estado == 'RR') selected @endif>Roraima</option>
                                            <option value="SC" @if ($item->estado == 'SC') selected @endif>Santa Catarina</option>
                                            <option value="SP" @if ($item->estado == 'SP') selected @endif>São Paulo</option>
                                            <option value="SE" @if ($item->estado == 'SE') selected @endif>Sergipe</option>
                                            <option value="TO" @if ($item->estado == 'TO') selected @endif>Tocantins</option>
                                        </select>
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
                                <a href="fixed-student-account-edit-profile.html" class="nav-link active">Minha Conta</a>
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

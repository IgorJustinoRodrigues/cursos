@php @session_start(); @endphp

@extends('template.aluno-login')
@section('title', 'Acesso de Aluno')

@section('header')
@endsection

@section('footer')
    <script>
        function login() {
            $("#div-login").removeClass('d-none');
            $("#div-cadastro").addClass('d-none');
        }

        function cadastro() {
            $("#div-login").addClass('d-none');
            $("#div-cadastro").removeClass('d-none');
        }
        

        @if ($tela == 'cadastro' and (!isset($_SESSION['ativacao_start']) and $_SESSION['ativacao_start']['matricula']->id == null))
            cadastro();
        @else
            login();
        @endif

        function verificaSenha() {
            var senha = $("#senha").val();
            var senha2 = $("#senha2").val();

            if (senha == '' && senha2 == '') {
                $("#msg-senha").text("");
                return null;
            }
            $('#btn-cadastro').attr('disabled', true);

            var verifica = 3 * (senha.length / 4);
            if (senha2.length > verifica) {
                if (senha == senha2) {
                    $('#btn-cadastro').attr('disabled', false);
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
            } else {
                if ($('#senha').val().match(numeros) && $('#senha').val().match(alfabeto)) {
                    $('#senha-status').html("<span style='color:green'><b>Senha forte</b></span>");
                } else {
                    $('#senha-status').html("<span style='color:orange'>Senha médio</span>");
                }
            }
        }

        $('#btn-cadastro').attr('disabled', true);
    </script>
@endsection

@section('conteudo')
    <div class="d-flex align-items-center" style="min-height: 100vh">
        <div class="col-sm-8 col-md-6 col-lg-4 mx-auto" style="min-width: 300px;">

            @if (isset($_SESSION['ativacao_start']) and $_SESSION['ativacao_start']['matricula']->id != null)
                <div class="card navbar-shadow mt-5 d-none" id="div-cadastro">
                    <div class="card-header text-center">
                        <h4 class="card-title">Cadastro</h4>
                        <p class="card-subtitle">Crie sua conta</p>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('loginAluno') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="nome">Nome:</label>
                                <div class="input-group input-group-merge">
                                    <input id="nome" type="text" required="" class="form-control form-control-prepended"
                                        placeholder="Informe o seu nome completo">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="far fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">E-mail:</label>
                                <div class="input-group input-group-merge">
                                    <input id="email" type="email" required="" class="form-control form-control-prepended"
                                        placeholder="Seu melhor e-mail">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="far fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="senha">Senha:</label>
                                <div class="input-group input-group-merge">
                                    <input id="senha" type="password" required=""
                                        class="form-control form-control-prepended"
                                        onkeyup="verificaSenha(); verificaForcaSenha();" placeholder="Crie uma senha">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fa fa-key"></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="senha-status"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="senha2">Senha:</label>
                                <div class="input-group input-group-merge">
                                    <input id="senha2" type="password" required=""
                                        class="form-control form-control-prepended" placeholder="Confirme a sua senha"
                                        onkeyup="verificaSenha()">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="fa fa-key"></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="msg-senha"></div>
                            </div>
                            <div class="form-group">
                                <div class="d-flex">
                                    <div class="flex">
                                        <a href="{{ route('inicio') }}" class="btn btn-default btn-wide">Voltar</a>
                                    </div>
                                    <button type="submit" class="btn btn-success mb-3" id="btn-cadastro">Criar
                                        Conta</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center text-black-50">Já tem uma conta? <a onclick="login()"
                            class="link">Acessar conta</a>
                    </div>
                </div>
            @endif
            <div class="card navbar-shadow d-none" id="div-login">
                <div class="card-header text-center">
                    <h4 class="card-title">Login Aluno</h4>
                    <p class="card-subtitle">Acesse seus cursos</p>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('loginAluno') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="email">E-mail:</label>
                            <div class="input-group input-group-merge">
                                <input id="email" type="email" name="email" value="@if (Cookie::get('aluno_email') != null)<?= Cookie::get('aluno_email') ?>@else{{ old('email') }}@endif" required
                                    class="form-control form-control-prepended" placeholder="E-mail de acesso">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="far fa-user"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="senha">Senha:</label>
                            <div class="input-group input-group-merge">
                                <input id="senha" type="password" name="senha" value="<?= Cookie::get('aluno_senha') ?>"
                                    required class="form-control form-control-prepended" placeholder="********"
                                    minlength="6" autocomplete="current-password">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fa fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10"><label>
                                    <input type="checkbox" name="remember" @if (Cookie::get('aluno_email') != null) checked="checked" @endif>
                                    Lembrar senha</label>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="d-flex">
                                <div class="flex">
                                    <a href="{{ route('inicio') }}" class="btn btn-default btn-wide">Voltar</a>
                                </div>
                                <button type="submit" class="btn btn-success mb-3">Acessar</button>
                            </div>
                        </div>
                    </form>
                </div>
                @if (isset($_SESSION['ativacao_start']) and $_SESSION['ativacao_start']['matricula']->id != null)
                    <div class="card-footer text-center text-black-50">Não tem uma conta? <a onclick="cadastro()"
                            class="link">Criar conta</a>
                    </div>
                @endif
            </div>
            <p class="text-muted text-center"><small>Copyright © Centro Educacional Start - {{ date('Y') }}</small>
            </p>
        </div>
    </div>

@endsection

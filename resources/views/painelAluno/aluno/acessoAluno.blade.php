@extends('template.aluno-login')
@section('title', 'Acesso de Aluno')

@section('header')
@endsection

@section('footer')
@endsection

@section('conteudo')
    <div class="d-flex align-items-center" style="min-height: 100vh">
        <div class="col-sm-8 col-md-6 col-lg-4 mx-auto" style="min-width: 300px;">
            <div class="card navbar-shadow">
                <div class="card-header text-center">
                    <h4 class="card-title">Login Aluno</h4>
                    <p class="card-subtitle">Acesso restrito</p>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('loginAluno') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label" for="usuario">Usuário:</label>
                            <div class="input-group input-group-merge">
                                <input id="usuario" type="usuario" name="usuario" value="@if (Cookie::get('aluno_usuario') != null)<?= Cookie::get('aluno_usuario') ?>@else{{ old('usuario') }}@endif" required
                                    class="form-control form-control-prepended" placeholder="Usuário de acesso">
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
                                    autocomplete="current-password">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="fa fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('recuperacaoAluno') }}">Recuperar Senha</a>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10"><label>
                                    <input type="checkbox" name="remember" @if (Cookie::get('aluno_usuario') != null) checked="checked" @endif>
                                    Lembrar senha</label>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="d-flex">
                                <div class="flex">
                                    <a href="{{ route('inicio') }}" class="btn btn-default btn-wide">Voltar</a>
                                </div>
                                <button type="submit" class="btn btn-success">Acessar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-muted text-center"><small>Copyright © Centro Educacional Start - {{ date('Y') }}</small></p>
        </div>
    </div>

@endsection

@extends('template.aluno')

@section('link')
@endsection

@section('conteudo')
<div class="row m-0">
    <div class="col-lg container-fluid page__container">
        <h1 class="h2">Informações Básicas</h1>
        <div class="card">
            <div class="list-group list-group-fit">
                <div class="list-group-item">
                    <div class="form-group m-0" role="group" aria-labelledby="label-firstname">
                        <div class="form-row">
                            <label id="label-firstname" for="firstname" class="col-md-3 col-form-label form-label">Nome Completo</label>
                            <div class="col-md-9">
                                <input id="firstname" type="text" placeholder="Your Nome Completo" value="Alexander" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="form-group m-0" role="group" aria-labelledby="label-lastname">
                        <div class="form-row">
                            <label id="label-lastname" for="lastname" class="col-md-3 col-form-label form-label">Telefone</label>
                            <div class="col-md-9">
                                <input id="lastname" type="text" placeholder="Your last name" value="Watson" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="form-group m-0" role="group" aria-labelledby="label-email">
                        <div class="form-row">
                            <label id="label-email" for="email" class="col-md-3 col-form-label form-label">E-mail</label>
                            <div class="col-md-9">
                                <div role="group" class="input-group input-group-merge">
                                    <input id="email" type="email" placeholder="Your email address" value="alexander.watson@gmail.com" class="form-control form-control-prepended">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="material-icons">email</i>
                                        </div>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Use sempre o seu melhor e-mail.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4>Segurança</h4>

        <div class="alert alert-light border-1 border-left-3 border-left-primary d-flex">
            <i class="material-icons text-success mr-3">check_circle</i>
            <div class="text-body">Crie uma senha com no mínimo 6 caracteres, contendo letras e números. Não compartilhe essa senha com ninguém!</div>
        </div>

        <div class="card">
            <div class="list-group list-group-fit">
                <div class="list-group-item">
                    <div class="form-group m-0" role="group" aria-labelledby="label-password">
                        <div class="form-row">
                            <label id="label-password" for="password" class="col-sm-3 col-form-label form-label">Senha:</label>
                            <div class="col-sm-9">
                                <div role="group" class="input-group input-group-merge form-control-prepended">
                                    <input id="password" type="password" required="required" placeholder="Digite sua senha" aria-required="true" class="form-control form-control-prepended">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="far fa-key"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="form-group m-0" role="group" aria-labelledby="label-password2">
                        <div class="form-row">
                            <label id="label-password2" for="password2" class="col-sm-3 col-form-label form-label">Confirmar Senha:</label>
                            <div class="col-sm-9">
                                <div role="group" class="input-group input-group-merge form-control-prepended">
                                    <input id="password2" type="password" required="required" placeholder="Confirme a sua senha" aria-required="true" class="form-control form-control-prepended">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <span class="far fa-key"></span>
                                        </div>
                                    </div>
                                </div>
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
                        <a href="" class="nav-link active">Informações básicas</a>
                    </li>
                </ul>
                <div class="page-nav__content">
                    <a href="{{ route('painel-aluno') }}" class="btn btn-success">Salvar alterações</a>
                </div>
            </div>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
    </div>
</div>
@endsection

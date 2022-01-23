@extends('template.aluno')
@section('title', 'Painel de aluno')

@section('footer')
    <!-- Global Settings -->
    <script src="{{ URL::asset('template/js/settings.js') }}"></script>

    <!-- Moment.js -->
    <script src="{{ URL::asset('template/vendor/moment.min.js') }}"></script>
    <script src="{{ URL::asset('template/vendor/moment-range.js') }}"></script>
@endsection

@section('conteudo')
    <div class="container page__container p-0">
        <form action="{{ route('salvarMinhasInformacoes', $item) }}" method="post" enctype="multipart/form-data" class="row m-0">
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
                                    <label id="label-avatar" for="avatar" class="col-md-3 col-form-label form-label">Your
                                        photo</label>
                                    <div class="col-md-9">
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
                                                        class="custom-file-input">
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
                                    <label id="label-nome" for="nome" class="col-md-3 col-form-label form-label">Nome</label>
                                    <div class="col-md-9">
                                        <input type="text" id="nome" placeholder="Informe o seu nome"
                                            class="form-control" value="{{ $item->nome }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-nascimento" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-nascimento" for="nascimento" class="col-md-3 col-form-label form-label">Data de Nascimento</label>
                                    <div class="col-md-3">
                                        <input type="date" id="nascimento" placeholder="Informe o seu nascimento"
                                            class="form-control" value="{{ $item->nascimento }}">
                                    </div>
                                    <label id="label-sexo" for="sexo" class="col-md-2 col-form-label form-label text-right">Sexo</label>
                                    <div class="col-md-4">
                                        <select id="sexo" name="sexo" class="form-control">
                                            <option value="">-</option>
                                            <option value="1">Masculino</option>
                                            <option value="2">Feminino</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div role="group" aria-labelledby="label-about" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="label-about" for="about" class="col-md-3 col-form-label form-label">About
                                        you</label>
                                    <div class="col-md-9">
                                        <textarea id="about" placeholder="About you ..." rows="3"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <fieldset role="group" aria-labelledby="legend-display_realname"
                                aria-describedby="description-display_realname" class="m-0 form-group">
                                <div class="form-row">
                                    <label id="legend-display_realname" for="display_realname"
                                        class="col-md-3 col-form-label form-label">Privacy</label>
                                    <div role="group" aria-labelledby="legend-display_realname" class="col-md-9">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input id="display_realname" type="checkbox" class="custom-control-input"
                                                checked="">
                                            <label for="display_realname" class="custom-control-label">Display your real
                                                name on your profile</label>
                                        </div>
                                        <small id="description-display_realname" class="form-text text-muted">If unchecked,
                                            your profile name will be displayed instead of your full name.</small>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="list-group-item">
                            <fieldset role="group" aria-describedby="description-public_profile" class="m-0 form-group">
                                <div class="form-row">
                                    <div class="col-md-3"></div>
                                    <div role="group" class="col-md-9">
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input id="public_profile" type="checkbox" class="custom-control-input"
                                                checked="">
                                            <label for="public_profile" class="custom-control-label">Allow everyone to see
                                                your profile</label>
                                        </div>
                                        <small id="description-public_profile" class="form-text text-muted">If unchecked,
                                            your profile will be private and one one except you will be able to view
                                            it.</small>
                                    </div>
                                </div>
                            </fieldset>
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
                            <button class="btn btn-success">Salvar Alterações</button>
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

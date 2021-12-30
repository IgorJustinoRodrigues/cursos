@extends('template.admin')
@section('title', 'Professor')
@section('menu-professor', 'true')

@section('footer')

@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Edição de Professor</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('professorSalvar', $item) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="form-row">
                            <div class="col-9 col-md-11 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ $item->nome }}" required="">
                            </div>
                            <div class="col-3 col-md-1 mb-3">
                                @if ($item->avatar != '')
                                    <img src="{{ URL::asset('storage/' . $item->avatar) }}" alt="" class="avatar-img">
                                @else
                                    <img src="{{ URL::asset('storage/avatarProfessor/padrao.png') }}" alt=""
                                        class="avatar-img">
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="avatar">Avatar</label>
                                <input type="file" class="form-control" id="avatar" name="avatar">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail"
                                    value="{{ $item->email }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="facebook">Facebook</label>
                                <input type="url" class="form-control" id="facebook" name="facebook" placeholder="URL do Facebook"
                                    value="{{ $item->facebook }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="instagram">Instagram</label>
                                <input type="url" class="form-control" id="instagram" name="instagram" placeholder="URL do Instagram"
                                    value="{{ $item->instagram }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="linkedin">Linkedin</label>
                                <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="URL do Linkedin"
                                    value="{{ $item->linkedin }}">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="site">Site</label>
                                <input type="url" class="form-control" id="site" name="site" placeholder="URL do Site"
                                    value="{{ $item->site }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="curriculo">Currículo</label>
                                <textarea class="form-control" id="curriculo" placeholder="Anotações" name="curriculo"
                                    rows="3">{{ $item->curriculo }}</textarea>
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
                                <a href="{{ route('professorIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('template.admin')
@section('title', 'Categoria de Curso')
@section('menu-categoriaCurso', 'true')

@section('footer')

@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Edição de Categoria de Curso</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('categoriaCursoSalvar', $item) }}" enctype="multipart/form-data">
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
                                @if ($item->imagem != '')
                                    <img src="{{ URL::asset('storage/' . $item->imagem) }}" alt="" class="avatar-img">
                                @else
                                    <img src="{{ URL::asset('storage/imagemCategoriaCurso/padrao.png') }}" alt=""
                                        class="avatar-img">
                                @endif
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label" for="imagem">Imagem</label>
                                <input type="file" class="form-control" id="imagem" name="imagem">
                            </div>
                        </div>

                        <div class="form-row">

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
                                <a href="{{ route('categoriaCursoIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

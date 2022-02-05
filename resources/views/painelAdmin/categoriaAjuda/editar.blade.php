@extends('template.admin')
@section('title', 'Categoria de Ajuda')
@section('menu-categoria-ajuda', 'true')

@section('footer')

@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Edição de Categoria de Ajuda</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('categoriaAjudaSalvar', $item) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="form-row">
                            <div class="col-11 mb-3">
                                <label class="form-label" for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"
                                    value="{{ $item->nome }}" required="">
                            </div>
                            <div class="col-1 mb-3 text-center"  style="font-size: 50px !important">
                                @if($item->icone != '')
                                    {!! $item->icone !!}
                                @else
                                    <i class="icofont-learn"></i>
                                @endif
                            </div>
                            <div class="col-5 mb-3">
                                <label class="form-label" for="icone">Ícone</label>
                                <input type="text" class="form-control" id="icone" name="icone" placeholder="Código HTML"
                                    value="{{ $item->icone }}">
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
                                <a href="{{ route('categoriaAjudaIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

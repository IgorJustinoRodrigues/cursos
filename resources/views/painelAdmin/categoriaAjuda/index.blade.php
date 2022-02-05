@extends('template.admin')
@section('title', 'Categoria de Ajuda')
@section('menu-categoria-ajuda', 'true')

@section('footer')

@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Listagem de Categoria de Ajuda</h1>
            <a href="{{ route('categoriaAjudaCadastro') }}" class="btn btn-success">Cadastro</a>
        </div>


        <div class="mb-4 d-flex align-items-center">
            <small class="text-black-70 mr-3">
                @if ($paginacao->total() > 1)
                    Exibindo {{ $paginacao->firstItem() }} ao {{ $paginacao->lastItem() }} de
                    {{ $paginacao->total() }} Registros
                @elseif($paginacao->total() == 1)
                    {{ $paginacao->total() }} Registro
                @else
                    Não há registros
                @endif
            </small>
            <!-- Search -->
            <form class="flex search-form form-control-rounded search-form--light mb-2 col-md-12"
                action="{{ route('categoriaAjudaIndex') }}" method="GET" style="min-width: 200px;">
                <input type="hidden" name="page" value="1" />
                <input type="text" class="form-control" placeholder="Digite sua busca" id="busca"
                    value="{{ $busca }}" name="busca" required>
                <button class="btn pr-3" type="submit" role="button"><i class="material-icons">search</i></button>
                @if (@$busca)
                    <a href="{{ route('categoriaAjudaIndex') }}" class="btn pr-3 text-danger" type="button"
                        role="button"><i class="material-icons">close</i></a>
                @endif
            </form>
        </div>

        <div class="card">
            <table class="table-responsive table">
                <thead>
                    <tr>
                        <th style="width: 10%">Ícone</th>
                        <th style="width: 50%">Nome</th>
                        <th style="width: 30%">Status</th>
                        <th style="width: 10%">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginacao as $item)
                        <tr>
                            <td class="text-center" style="font-size: 50px !important">
                                @if($item->icone != '')
                                    {!! $item->icone !!}
                                @else
                                    <i class="icofont-learn"></i>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('categoriaAjudaEditar', $item->id) }}">
                                    {{ $item->nome }}
                                </a>
                            </td>
                            <td>{{ app(App\Http\Controllers\CategoriaAjudaController::class)->status($item->status) }}</td>
                            <td class="table-dropdown text-center">
                                <a href="{{ route('categoriaAjudaEditar', $item->id) }}" class="btn btn-success">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a onclick="confirmacao('{{ route('categoriaAjudaDeletar', $item->id) }}', '<h3>Realmente deseja excluir essa categoria de ajuda?</h3><p>{{ $item->nome }}</p>')"
                                    class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $paginacao->links('template.paginacao.admin', ['busca' => $busca]) }}
    </div>
@endsection

@extends('template.admin')
@section('title', 'Unidade')
@section('menu-unidade', 'true')

@section('footer')

@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Listagem de Unidades</h1>
            <a href="{{ route('unidadeCadastro') }}" class="btn btn-success">Cadastro</a>
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
                action="{{ route('unidadeIndex') }}" method="GET" style="min-width: 200px;">
                <input type="hidden" name="page" value="1" />
                <input type="text" class="form-control" placeholder="Digite sua busca" id="busca"
                    value="{{ $busca }}" name="busca" required>
                <button class="btn pr-3" type="submit" role="button"><i class="material-icons">search</i></button>
                @if (@$busca)
                    <a href="{{ route('unidadeIndex') }}" class="btn pr-3 text-danger" type="button" role="button"><i
                            class="material-icons">close</i></a>
                @endif
            </form>
        </div>

        <div class="card">
            <table class="table-responsive table">
                <thead>
                    <tr>
                        <th style="width: 5%">Logo</th>
                        <th style="width: 50%">Nome</th>
                        <th style="width: 35%">Unidade</th>
                        <th style="width: 10%">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginacao as $item)
                        <tr>
                            <td class="text-center">
                                <a href="{{ route('unidadeEditar', $item->id) }}">
                                    @if ($item->avatar != '')
                                        <img src="{{ URL::asset('storage/' . $item->avatar) }}" alt=""
                                            class="avatar-img">
                                    @else
                                        <img src="{{ URL::asset('storage/avatarUnidade/padrao.png') }}" alt=""
                                            class="avatar-img">
                                    @endif
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('unidadeEditar', $item->id) }}">
                                    {{ $item->nome }}
                                </a>
                            </td>
                            <td>{{ $item->unidade }}</td>
                            <td class="table-dropdown text-center">
                                <a href="{{ route('unidadeEditar', $item->id) }}" class="btn btn-success">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a onclick="confirmacao('{{ route('unidadeDeletar', $item->id) }}', '<h3>Realmente deseja excluir esse unidade?</h3><p>{{ $item->nome }}</p>')"
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

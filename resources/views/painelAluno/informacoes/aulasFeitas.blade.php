@extends('template.aluno')
@section('title', 'Aulas Feitas')
@section('menu-informacoes', 'true')

@section('footer')

@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Aulas Feitas</h1>
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
                action="{{ route('aulasFeitas') }}" method="GET" style="min-width: 200px;">
                <input type="hidden" name="page" value="1" />
                <input type="text" class="form-control" placeholder="Digite sua busca" id="busca"
                    value="{{ $busca }}" name="busca" required>
                <button class="btn pr-3" type="submit" role="button"><i class="material-icons">search</i></button>
                @if (@$busca)
                    <a href="{{ route('aulasFeitas') }}" class="btn pr-3 text-danger" type="button" role="button"><i
                            class="material-icons">close</i></a>
                @endif
            </form>
        </div>

        <div class="card">
            <table class="table-responsive table">
                <thead>
                    <tr>
                        <th style="width: 20%">Tipo de Aula</th>
                        <th style="width: 20%">Curso</th>
                        <th style="width: 35%">Aula</th>
                        <th style="width: 25%">Status</th>
                        <th style="width: 10%">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginacao as $linha)

                        <tr>
                            <td>
                                {!! app(App\Http\Controllers\AulaController::class)->tipo($linha->tipo, $linha->avaliacao, true) !!}
                                {!! app(App\Http\Controllers\AulaController::class)->tipo($linha->tipo, $linha->avaliacao) !!}
                            </td>
                            <td>
                                <a
                                    href="{{ route('verAulas', [$linha->curso_id, Str::slug($linha->curso, '-') . '.html']) }}">
                                    {{ $linha->curso }}
                                </a>
                            </td>
                            <td>
                                <a
                                    href="{{ route('aula', [$linha->curso_id, Str::slug($linha->curso, '-'), $linha->aula_id, Str::slug($linha->aula, '-') . '.html']) }}">
                                    {{ $linha->aula }}
                                </a>
                            </td>
                            <td>
                                @if ($linha->conclusao != null)
                                    {{ app(App\Http\Controllers\AulaController::class)->msgNota($linha->nota) }} | Nota:
                                    {{ number_format($linha->nota, 2, '.', '') }}%
                                @else
                                    Aula iniciada em {{ $linha->created_at->format('d/m') }} às
                                    {{ $linha->created_at->format('H:i') }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('aula', [$linha->curso_id, Str::slug($linha->curso, '-'), $linha->aula_id, Str::slug($linha->aula, '-') . '.html']) }}"
                                    class="btn btn-success btn-sm">
                                    Acessar
                                    <i class="material-icons btn__icon--right">play_arrow</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $paginacao->links('template.paginacao.aluno', ['busca' => $busca]) }}
    </div>
@endsection

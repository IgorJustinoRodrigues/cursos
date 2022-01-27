@extends('template.aluno')

@section('title', '')

@section('link')
@endsection

@section('header')
@endsection

@section('footer')
@endsection

@section('conteudo')
    <div class="media mb-headings align-items-center">
        <div class="media-body">
            <h1 class="h2">{{ $aula->nome }}</h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body media align-items-center">
            <div class="media-body">
                @if ($aula->avaliacao == 1)
                    <h4 class="mb-0">{{ app(App\Http\Controllers\AulaController::class)->msgNota($nota) }}</h4>
                    <span class="text-muted-light">Quiz avaliativo, o seu desempenho foi {{ $nota }}</span>
                @else
                    <h4 class="mb-0">Aula concluida!</h4>
                    <span class="text-muted-light">Quiz não avaliativo, o seu desempenho foi {{ $nota }}</span>
                @endif
            </div>
            <div class="media-right">
                @if ($nota >= 60)
                    <a href="{{ route('verAulas', [$curso->id, Str::slug($curso->nome, '-') . '.html']) }}"
                        class="btn btn-primary">Voltar para aulas</a>
                @else
                    <a href="{{ route('aula', [$curso->id, Str::slug($curso->nome, '-'), $aula->id, Str::slug($aula->nome, '-') . '.html']) }}"
                        class="btn btn-warning">Tentar novamente <i class="material-icons btn__icon--right">refresh</i></a>
                @endif
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Correção</h4>
        </div>
        <ul class="list-group list-group-fit mb-0">
            @foreach ($pergunta_certa as $linha)
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-body">
                            {{ $linha->pergunta }}
                            <div class="text-muted-light">Resposta marcada: {{ $linha->marcada->resposta }}</div>
                        </div>
                        <div class="media-right"><span class="badge badge-success">Correta</span></div>
                    </div>
                </li>
            @endforeach
            @foreach ($pergunta_errada as $linha)
                <li class="list-group-item">
                    <div class="media">
                        <div class="media-body">
                            {{ $linha->pergunta }}
                            <div class="text-muted-light">Resposta marcada: {{ $linha->marcada->resposta }}</div>
                        </div>
                        <div class="media-right"><span class="badge badge-danger ">Incorreta</span></div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

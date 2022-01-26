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
        <div class="media-left">
            <img src="assets/images/vuejs.png" alt="" width="80" class="rounded">
        </div>
        <div class="media-body">
            <h1 class="h2">{{ $aula->nome }}</h1>
        </div>
    </div>
    <div class="card">
        <div class="card-body media align-items-center">
            <div class="media-body">
                <h4 class="mb-0">{{ app(App\Http\Controllers\AulaController::class)->msgNota($nota) }}</h4>
                <span class="text-muted-light">A sua nota foi {{ $nota }}</span>
            </div>
            <div class="media-right">
                @if($nota >= 60)
                <a href="{{ route('verAulas', [$curso->id, Str::slug($curso->nome, '-') . '.html']) }}" class="btn btn-primary">Voltar para aulas</a>
                @else
                <a href="{{ route('aula', [$curso->id, Str::slug($curso->nome, '-'), $aula->id, Str::slug($aula->nome, '-') . '.html']) }}" class="btn btn-warning">Tentar novamente <i class="material-icons btn__icon--right">refresh</i></a>
                @endif
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Confira as perguntas que você errou</h4>
        </div>
        <ul class="list-group list-group-fit mb-0">
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
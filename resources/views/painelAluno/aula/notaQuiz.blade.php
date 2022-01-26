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
                <h4 class="mb-0">A sua nota foi {{ $nota }}</h4>
                <span class="text-muted-light">{{ app(App\Http\Controllers\AulaController::class)->msgNota($nota) }}</span>
            </div>
            <div class="media-right">
                @if($nota >= 60)
                <a href="fixed-student-take-quiz.html" class="btn btn-primary">Voltar para aulas</a>
                @else
                <a href="fixed-student-take-quiz.html" class="btn btn-warning">Tentar novamente <i class="material-icons btn__icon--right">refresh</i></a>
                @endif
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Questions</h4>
        </div>
        <ul class="list-group list-group-fit mb-0">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <div class="text-muted-light">1.</div>
                    </div>
                    <div class="media-body">Installation</div>
                    <div class="media-right"><span class="badge badge-success ">Correct</span></div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <div class="text-muted-light">2.</div>
                    </div>
                    <div class="media-body">The MVC architectural pattern</div>
                    <div class="media-right"><span class="badge badge-success ">Correct</span></div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <div class="text-muted-light">3.</div>
                    </div>
                    <div class="media-body">Database Models</div>
                    <div class="media-right"><span class="badge badge-success ">Correct</span></div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <div class="text-muted-light">4.</div>
                    </div>
                    <div class="media-body">Database Access</div>
                    <div class="media-right"><span class="badge badge-danger ">Wrong</span></div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <div class="text-muted-light">5.</div>
                    </div>
                    <div class="media-body">Eloquent Basics</div>
                    <div class="media-right"><span class="badge badge-primary ">Pending Review</span></div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="media">
                    <div class="media-left">
                        <div class="text-muted-light">6.</div>
                    </div>
                    <div class="media-body">Take Quiz</div>
                    <div class="media-right"><span class="badge badge-success ">Correct</span></div>
                </div>
            </li>
        </ul>
    </div>
@endsection
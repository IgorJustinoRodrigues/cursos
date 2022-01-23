@extends('template.aluno')

@section('link')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="student-dashboard.html">Início</a></li>
        <li class="breadcrumb-item active">Meus Cursos</li>
    </ol>
@endsection

@section('conteudo')
    <div class="container-fluid page__container">
        <div class="media mb-headings align-items-center">
            <div class="media-body">
                <h1 class="h2">Meus cursos</h1>
            </div>
            <div class="media-right">
                <div class="btn-group btn-group-sm">
                    <a href="#" class="btn btn-white active"><i class="material-icons">list</i></a>
                    <a href="#" class="btn btn-white"><i class="material-icons">dashboard</i></a>
                </div>
            </div>
        </div>
        <div class="card-columns">
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-left">
                            <a href="">
                                <img src="{{ URL::asset('template/images/vuejs.png') }}" alt="Card image cap" width="100"
                                    class="rounded">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="card-title m-0"><a href="">Learn VueJs the easy way!</a></h4>
                            <small class="text-muted">Lessons: 3 of 7</small>
                        </div>
                    </div>
                </div>
                <div class="progress rounded-0">
                    <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 40%"
                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="card-footer bg-white">
                    <a href="" class="btn btn-primary btn-sm">Continue <i
                            class="material-icons btn__icon--right">play_circle_outline</i></a>
                </div>
            </div>

           



    
        </div>
    </div>


@endsection

@extends('template.aluno-login')

@section('conteudo')
    <div class="d-flex align-items-center" style="min-height: 100vh">
        <div class="col-sm-8 col-md-6 col-lg-4 mx-auto" style="min-width: 300px;">
            <div class="card navbar-shadow">
                <div class="card-header text-center">
                    <h4 class="card-title">Login</h4>
                    <p class="card-subtitle">Acesso ao seu curso</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('info-aluno') }}" novalidate method="get">
                        <div class="form-group">
                            <label class="form-label" for="cpf">CPF ou Código de Ativação:</label>
                            <div class="input-group input-group-merge">
                                <input id="cpf" type="cpf" required="" class="form-control form-control-prepended"
                                    placeholder="Informe o seu CPF ou código de ativação">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="far fa-address-card"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <button type="submit" class="btn btn-primary btn-block">Acessar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

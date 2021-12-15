@extends('template.painel-admin')
@section('title', 'Edição de Administrador')
@section('menu-admin', 'true')  

@section('header')
    <!-- ========== COMMON STYLES ========== -->
    <link rel="stylesheet" href="{{ URL::asset('painelAdmin/css/bootstrap.css') }}" media="screen">
    <link rel="stylesheet" href="{{ URL::asset('painelAdmin/css/font-awesome.min.css') }}" media="screen">
    <link rel="stylesheet" href="{{ URL::asset('painelAdmin/css/animate-css/animate.min.css') }}" media="screen">
    <link rel="stylesheet" href="{{ URL::asset('painelAdmin/css/lobipanel/lobipanel.min.css') }}" media="screen">

    <!-- ========== PAGE STYLES ========== -->
    <link rel="stylesheet" href="{{ URL::asset('painelAdmin/css/prism/prism.css') }}" media="screen">
    <link rel="stylesheet" href="{{ URL::asset('painelAdmin/css/summernote/summernote.css') }}" >
    
    <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->

    <!-- ========== THEME CSS ========== -->
    <link rel="stylesheet" href="{{ URL::asset('painelAdmin/css/main.css') }}" media="screen">

    <!-- ========== MODERNIZR ========== -->
    <script src="{{ URL::asset('painelAdmin/js/modernizr/modernizr.min.js') }}"></script>
@endsection

@section('footer')
    <!-- ========== COMMON JS FILES ========== -->
    <script src="{{ URL::asset('painelAdmin/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ URL::asset('painelAdmin/js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('painelAdmin/js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('painelAdmin/js/pace/pace.min.js') }}"></script>
    <script src="{{ URL::asset('painelAdmin/js/lobipanel/lobipanel.min.js') }}"></script>
    <script src="{{ URL::asset('painelAdmin/js/iscroll/iscroll.js') }}"></script>

    <!-- ========== PAGE JS FILES ========== -->
    <script src="{{ URL::asset('painelAdmin/js/prism/prism.js') }}"></script>
    <script src="{{ URL::asset('painelAdmin/js/summernote/summernote.min.js') }}"></script>
    <!-- ========== THEME JS ========== -->
    <script src="{{ URL::asset('painelAdmin/js/main.js') }}"></script>

    <script src="{{ URL::asset('painelAdmin/js/admin/cadastro.js') }}"></script>



    <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
@endsection

@section('links')
    <li><a href="{{ route('adminIndex') }}">Admin</a></li>
    <li class="active">Edição</li>
@endsection

@section('help')
    <h4>Ajuda da página <i class="fa fa-times close-icon"></i></h4>
    A tela de edição é usada para editar um registro existente de Administrador<br><br>
    <b>Os campos disponíveis são:</b><br>
    <i class="fa fa-check"></i> Nome<br>
    <i class="fa fa-check"></i> E-mail<br>
    <i class="fa fa-check"></i> Avatar<br>
    <i class="fa fa-check"></i> Tipo<br>
    <i class="fa fa-check"></i> Anotações<br>
    <i class="fa fa-check"></i> Senha<br>

    <br><br>
    <b>Os campos obrigatórios são:</b><br>
    <i class="fa fa-check"></i> Nome<br>
    <i class="fa fa-check"></i> E-mail<br>
    <i class="fa fa-check"></i> Tipo<br>
    <i class="fa fa-check"></i> Senha<br>
@endsection

@section('content')
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body p-20">
                <form class="p-20" method="POST" action="{{route('adminSalvar', $item)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$item->id}}">
                    <h5 class="underline mt-n">Edição de Administrador</h5>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nome">Nome<sup class='color-danger'>*</sup></label>
                                <input type="text" class="form-control" id="nome" placeholder="Nome" value="{{$item->nome}}" name="nome" required>
                            </div>
                        </div>
                        @if (@$_SESSION['admin']['tipo_numero_admin'] == '1') 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo">Tipo<sup class='color-danger'>*</sup></label>
                                <select class="form-control" id="tipo" name="tipo" required>
                                    <option @if ($item->tipo == 1) selected @endif value="1">Administração</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="avatar">Avatar</label>
                                <input type="file" class="form-control" value="{{old('avatar')}}" id="avatar" name="avatar">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">E-mail<sup class='color-danger'>*</sup></label>
                                <input type="email" class="form-control" id="email" placeholder="E-mail" value="{{$item->email}}" name="email" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="senha">Senha<sup class='color-danger'>*</sup></label>
                                <input type="password" class="form-control" id="senha" placeholder="*****" value="" name="senha">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="anotacoes">Anotações</label>
                                <textarea class="form-control" id="anotacoes" name="anotacoes">{{$item->anotacoes}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group pull-right mt-10" role="group">
                                <a href="{{route('adminIndex')}}" class="btn btn-default btn-wide"><i class="fa fa-arrow-left"></i>Voltar</a>
                                <button type="submit" class="btn btn-success btn-wide">Salvar <i class="fa fa-check"></i></button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                        <!-- /.col-md-12 -->
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

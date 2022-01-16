@extends('template.admin')
@section('title', 'Aulas do curso ' . $curso->nome)
@section('menu-curso', 'true')


@section('header')
    <link type="text/css" href="{{ URL::asset('template/css/quill.css') }}" rel="stylesheet">
    <!-- Touchspin -->
    <link rel="stylesheet" href="{{ URL::asset('template/css/bootstrap-touchspin.css') }}">
    <link href="{{ URL::asset('template/css/select2.min.css') }}" rel="stylesheet" />
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ URL::asset('template/css/nestable.css') }}">
@endsection

@section('footer')
    <script src="{{ URL::asset('template/vendor/quill.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/quill.js') }}"></script>
    <!-- Vendor JS -->
    <script src="{{ URL::asset('template/vendor/jquery.nestable.js') }}"></script>
    <script src="{{ URL::asset('template/vendor/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ URL::asset('template/js/select2.min.js') }}"></script>
    <!-- Initialize -->
    <script src="{{ URL::asset('template/js/nestable.js') }}"></script>
    <script src="{{ URL::asset('template/js/touchspin.js') }}"></script>
    <script>
        function prepararSubmit() {
            var descricao = $(".ql-editor").html();
            $("#input-descricao").val(descricao);

            return true;
        }

        $(document).ready(function() {
            $('.select2').select2();
        });

        document.getElementById("nestable").onchange = function() {
            myFunction()
        };

        function myFunction() {
            var i = 1;
            var ids = new Array();
            var orderms = new Array();

            $(".nestable-item").each(function(index) {
                $('#aula' + $(this).attr('data-id')).text(i + '.');
                $(this).attr('data-ordem', i++);

                ids.push($(this).attr('data-id'));
                orderms.push($(this).attr('data-ordem'));
            });

            var textoIds = JSON.stringify(ids);
            var textoOrderms = JSON.stringify(orderms);

            $.ajax({
                type: 'post',
                url: "{{ route('aulaOrdenar') }}",
                data: {
                    ids: textoIds,
                    ordems: textoOrderms,
                    curso_id: {{ $curso->id }},
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == '1') {
                        Lobibox.notify('success', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: data.msg
                        });
                    } else {
                        Lobibox.notify('warning', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: data.msg
                        });

                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1800);
                    }
                },
                error: function(data) {
                    Lobibox.notify('error', {
                        size: 'mini',
                        sound: false,
                        icon: false,
                        position: 'top right',
                        msg: "O sistema está passando por instabilidades no momento! Tente novamente mais tarde."
                    });

                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1800);
                }
            });
        }
    </script>


@endsection

@section('conteudo')
    @csrf
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Edição de Aulas do curso "{{ $curso->nome }}"</h1>
        </div>

        <div class="card card-body">

            <!-- Inicio do Tabs -->
            <div class="card-header">
                <a href="{{ route('aulaCadastro', [$curso]) }}" class="btn btn-outline-secondary">Inserir Nova
                    Aula <i class="material-icons"> add</i></a>
            </div>

            <div class="nestable" id="nestable">
                <ul class="list-group list-group-fit nestable-list-plain mb-0">
                    @php $i = 1; @endphp
                    @php $total_minuto = 0 @endphp
                    @foreach ($item as $linha)
                        @php $total_minuto += $linha->duracao @endphp
                        <li class="list-group-item nestable-item" data-id="{{ $linha->id }}"
                            data-ordem="{{ $i }}">
                            <div class="media align-items-center">
                                <div class="media-left">
                                    <a href="#" class="btn btn-default nestable-handle"><i
                                            class="material-icons">menu</i></a>
                                </div>
                                <div class="media-body">
                                    <small  class="font-size-20pt" id="aula{{ $linha->id }}">{{ $i }}.</small> <a
                                        href="{{ route('aulaEditar', [$curso, $linha]) }}" class="font-size-20pt">{{ $linha->nome }}
                                        |
                                        {{ app(App\Http\Controllers\AulaController::class)->tipo($linha->tipo, $linha->avaliacao) }}</a>
                                        <br>
                                        {{ app(App\Services\Services::class)->minuto_hora($linha->duracao) }}
                                </div>
                                <div class="media-right text-right">
                                    
                                    <div style="width:100px">
                                        <a data-toggle="modal" data-target="#editQuiz" class="btn btn-danger mb-1"
                                            onclick="confirmacao('{{ route('aulaDeletar', [$curso->id, $linha->id]) }}', '<h3>Realmente deseja excluir essa aula?</h3><p>{{ $curso->nome }}</p>')">
                                            <i class="material-icons">delete</i></a>
                                        <a href="{{ route('aulaEditar', [$curso, $linha->id]) }}"
                                            class="btn btn-primary"><i class="material-icons">edit</i></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @php $i++; @endphp
                    @endforeach
                    <li class="list-group-item">
                        <div class="media align-items-center">
                            <div class="media-body text-center btn btn-lg btn-light">
                                <i class="material-icons text-muted-light">schedule</i>&nbsp;
                                {{ app(App\Services\Services::class)->minuto_hora($total_minuto) }}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Final do Tabs -->
            <hr>
            <div class="d-flex">
                <div class="flex">
                    <a href="{{ route('cursoEditar', [$curso->id, 'aulas']) }}" class="btn btn-default btn-wide">VOLTAR
                        PARA O
                        CURSO</a>
                </div>
            </div>

        </div>

    </div>

@endsection

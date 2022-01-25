@extends('template.admin')
@section('title', 'Curso')
@section('menu-curso', 'true')

@section('header')
    <link type="text/css" href="{{ URL::asset('template/css/quill.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('template/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('template/css/dropzone.min.css') }}">
@endsection

@section('footer')

<div class="modal fade" id="modalDeletar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmação</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id-delete">
                <h3 id="div-descricao-delete"></h3>
            </div>
            <div class="modal-footer">
                <a onclick="$('#modalDeletar').modal('hide');" class="btn btn-dark">Fechar</a>
                <a onclick="excluirAjax()" class="btn btn-success">Confirmar</a>
            </div>
        </div>
    </div>
</div>


    <!-- Quill -->
    <script src="{{ URL::asset('template/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/dropzone.min.js') }}"></script>
    <script>
        Dropzone.options.myAwesomeDropzone = {
            paramName: "arquivo", // The name that will be used to transfer the file
            autoProcessQueue: true,
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
            maxFilesize: 10, // MB
            success: function(file, response) {
                Lobibox.notify('success', {
                    size: 'mini',
                    sound: false,
                    icon: false,
                    position: 'top right',
                    msg: response
                });

                this.removeFile(file);
                listarAnexo();
            },
            error: function(file, response) {
                if (typeof response.message !== "undefined") {
                    response.errors.arquivo.forEach(element => {
                        response.message += '\n' + element;
                    });

                    $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(response
                        .message);
                } else {
                    $(file.previewElement).addClass("dz-error").find('.dz-error-message').text(
                        response);
                }
            },
        };

        function prepararSubmit() {
            var texto = $(".ql-editor").html();
            $("#input-texto").val(texto);

            return true;
        }

        $(document).ready(function() {
            $('.select2').select2();
        });

        function tipoAula() {
            var tipo = $("#tipo").val();

            $(".div-ocultar").addClass('d-none');
            $("#video").addClass('d-none');

            switch (tipo) {
                case '1':
                    $(".video").removeClass('d-none');
                    $("#video").removeClass('d-none');
                    $(".texto").removeClass('d-none');
                    break;

                case '2':
                    $(".texto").removeClass('d-none');

                    break;
                case '3':
                    $(".pergunta").removeClass('d-none');

                    break;
            }
        }

        function player() {
            var div = $("#video").val();

            $("#player").html(div);
        }
        player();

        function addPergunta(id, resposta) {
            var id = id || "";
            var resposta = resposta || "";

            $("#modelo .pergunta .input-pergunta").val(resposta)
            $("#modelo .pergunta .input-id-pergunta").val(id)

            var div = $("#modelo .pergunta").clone();

            $("#modelo .pergunta .input-pergunta").val('')
            $("#modelo .pergunta .input-id-pergunta").val('')

            $("#div-pergunta").append(div);

            numerar();
        }

        function addResposta(elemento, id, respostas, correta) {
            var id = id || "";
            var respostas = respostas || "";
            var correta = correta || "";

            $("#modelo .resposta .input-resposta").val(respostas);
            $("#modelo .resposta .input-id-resposta").val(id);
            $('#modelo .resposta select option[value="' + correta + '"]').attr('selected', 'true');

            var div = $("#modelo .resposta").clone();

            $("#modelo .resposta .input-resposta").val('')
            $("#modelo .resposta .input-id-resposta").val('')
            $('#modelo .resposta select').find('option:selected').removeAttr('selected');

            elemento.parent().find('.div-resposta').append(div);

            numerar();
        }

        @foreach ($perguntas as $linha)
            addPergunta({{ $linha->id }}, '{{ $linha->pergunta }}');
            @foreach ($linha->respostas as $linha2)
                addResposta($('#div-pergunta').children('.pergunta').children('.item').children('a').last(),
                {{ $linha2->id }}, '{{ $linha2->resposta }}', '{{ $linha2->correta }}');
            @endforeach
        @endforeach

        function deletarPergunta(elemento) {
            elemento.parent().parent().parent().parent().empty();

            numerar();
        }

        function deletarResposta(elemento) {
            elemento.parent().parent().parent().empty();
        }

        function numerar() {
            var i = 1;

            $('#div-pergunta .pergunta .item .num_pergunta').each(function(index, element) {
                $(element).text('Pergunta ' + i)

                $(element).parent().parent().parent().find('.div-resposta .input-resposta').each(function(index2,
                    element2) {
                    $(element2).attr('name', 'resposta' + i + '[]');
                });

                $(element).parent().parent().parent().find('.div-resposta select').each(function(index3, element3) {
                    $(element3).attr('name', 'opcao' + i + '[]');
                });

                $(element).parent().parent().parent().find('.div-resposta .input-id-resposta').each(function(index4,
                    element4) {
                    $(element4).attr('name', 'id' + i + '[]');
                });

                i++;
            });
        }

        tipoAula();

        listarAnexo();

        function listarAnexo() {
            $("#div-anexos").empty();

            $.ajax({
                type: 'post',
                url: "{{ route('aulaListarAnexo') }}",
                data: {
                    _token: $("input[name='_token']").val(),
                    'id': {{ $item->id }}
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        data.anexos.forEach(item => {
                            div = '<div class="col-md-4 mt-10" style="border: 1px solid #e4e4e4;">';
                            div += '<h4>' + item.nome + '</h4>';
                            div += '<a href="{{ URL::asset('/storage') }}/' + item.arquivo +
                                '" target="_blank" class="btn btn-success"><i class="fa fa-search"></i> Visualizar arquivo</a>';
                            div += '<a onclick="excluir(' + item.id + ', ' + "'" + item.nome + "'" +
                                ')"  class="btn btn-danger"><i class="fa fa-trash"></i> Excluir</a>';
                            div += '<p>' + item.data + '</p>';
                            div += '</div>';
                            $("#div-anexos").append(div);
                        });
                    } else {
                        $("#div-anexos").append('<h3 class="text-center">' + data.msg + '</h3>');
                    }
                }
            });
        }

        function excluirAjax() {
            $.ajax({
                type: 'post',
                url: "{{ route('aulaDeletarAnexo') }}",
                data: {
                    _token: $("input[name='_token']").val(),
                    'id': $("#id-delete").val()
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {

                        Lobibox.notify('success', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: data.msg
                        });
                        $("#modalDeletar").modal("hide");
                        listarAnexo();
                    } else {

                        Lobibox.notify('warning', {
                            size: 'mini',
                            sound: false,
                            icon: false,
                            position: 'top right',
                            msg: data.msg
                        });
                    }
                }
            });
        }

        function excluir(id, nome) {
            $("#div-descricao-delete").text('Excluir o anexo "' + nome + '"?');
            $("#id-delete").val(id);

            $("#modalDeletar").modal("show");
        }
    </script>
    <script src="{{ URL::asset('template/vendor/quill.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/quill.js') }}"></script>
@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Edição de Aula</h1>
        </div>

        <div class="card card-body">

            <div class="card">
                <ul class="nav nav-tabs nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link active" href="#aula" data-toggle="tab">Informações</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#anexos" data-toggle="tab">Anexos</a>
                    </li>
                </ul>
                <div class="card-body tab-content">
                    <div class="tab-pane active" id="aula">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="POST" action="{{ route('aulaSalvar', [$curso->id, $item->id]) }}"
                                    onsubmit="return prepararSubmit();">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">
                                        <div class="col-12 col-md-4 mb-3">
                                            <label class="form-label" for="tipo">Tipo de Aula</label>
                                            <select id="tipo" class="form-control custom-select" name="tipo"
                                                onchange="tipoAula();">
                                                <option value="1" @if ($item->tipo == 1) selected @endif>Aula de Vídeo</option>
                                                <option value="2" @if ($item->tipo == 2) selected @endif>Aula de Texto</option>
                                                <option value="3" @if ($item->tipo == 3) selected @endif>Quiz</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4 mb-3 div-ocultar pergunta">
                                            <label class="form-label" for="avaliacao">Aula avaliativa?</label>
                                            <select id="avaliacao" class="form-control custom-select" name="avaliacao">
                                                <option value="1" @if ($item->avaliacao == 1) selected @endif>Sim</option>
                                                <option value="0" @if ($item->avaliacao == 0) selected @endif>Não</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <label class="form-label" for="nome">Nome</label>
                                            <input type="text" class="form-control" id="nome" name="nome"
                                                placeholder="Nome" value="{{ $item->nome }}" required>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <label class="form-label" for="descricao">Descrição</label>
                                            <textarea class="form-control" id="descricao" name="descricao"
                                                placeholder="Descrição da aula"
                                                rows="3">{{ $item->descricao }}</textarea>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <label class="form-label" for="duracao">Duração da Aula (Minutos)</label>
                                            <input type="number" min="1" step="1" class="form-control" id="duracao"
                                                name="duracao" placeholder="" value="{{ $item->duracao }}">
                                        </div>
                                        <div class="col-12 col-md-12 mb-3 div-ocultar video">
                                            <label class="form-label" for="video">Link do vídeo</label>
                                            <textarea class="form-control" id="video" name="video" placeholder="Link"
                                                onchange="player()">{{ $item->video }}</textarea>
                                            <hr>
                                            <div id="player"></div>
                                        </div>
                                        <div class="col-12 col-md-12 mb-3 div-ocultar texto">
                                            <label class="form-label">Texto</label>
                                            <div class="form-control" id="texto" data-toggle="quill"
                                                style="height: 350px;">{!! $item->texto !!}</div>
                                            <input type="hidden" name="texto" id="input-texto">
                                        </div>

                                        <div class="col-12 mb-3 div-ocultar pergunta">
                                            <hr>
                                            <div id="div-pergunta">

                                            </div>
                                            <a class="btn btn-primary mt-4 right" onclick="addPergunta()">NOVA PERGUNTA</a>
                                            <hr>
                                        </div>

                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label" for="status">Status</label>
                                            <select id="status" class="form-control custom-select" name="status">
                                                <option @if (old('status') == 1) selected @endif value="1">Ativo</option>
                                                <option @if (old('status') == 2) selected @endif value="2">Inativo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="d-flex">
                                        <div class="flex">
                                            <a href="{{ route('aulaIndex', [$curso]) }}"
                                                class="btn btn-default btn-wide">Voltar</a>
                                        </div>
                                        <button class="btn btn-success" type="submit">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="anexos">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="pt-0">Anexos</h4>
                                <form action="{{ route('aulaInserirAnexo') }}" method="post" class="dropzone"
                                    id="my-awesome-dropzone">
                                    @csrf
                                    <input type="hidden" name="aula_id" id="aula_id" value="{{ $item->id }}">
                                    <div class="dz-message needsclick">
                                        Enviar anexos. <br />
                                        <span class="note needsclick">(Clique ou arraste os itens para cá, o envio é
                                            automático)
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row" id="div-anexos"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="d-none" id="modelo">
        <div class="pergunta">
            <div style="border: 1px dashed#000; padding: 20px" class="item">
                <div class="row">
                    <input type="hidden" class="form-control input-id-pergunta" name="id_perguntas[]">
                    <div class="col-9">
                        <label class="form-label num_pergunta"></label>
                        <input type="text" class="form-control input-pergunta" name="perguntas[]">
                    </div>
                    <div class="col-3">
                        <a class="btn btn-danger btn-wide btn-block mt-4" onclick="deletarPergunta($(this))">DELETAR
                            PERGUNTA</a>
                    </div>
                </div>
                <hr>
                <div class="div-resposta">

                </div>
                <a class="btn btn-primary btn-sm mt-4 right" onclick="addResposta($(this))">NOVA
                    RESPOSTA</a>
            </div>
        </div>

        <div class="resposta">
            <div class="itemResposta m-2">
                <div class="row">
                    <input type="hidden" class="form-control input-id-resposta" name="id_respostas[]">
                    <div class="col-3">
                        <select class="form-control custom-select select-resposta">
                            <option value="1">Correta</option>
                            <option value="0">Incorreta</option>
                        </select>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control input-resposta">
                    </div>
                    <div class="col-1">
                        <a class="btn btn-danger btn-wide btn-block" onclick="deletarResposta($(this))">DELETAR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

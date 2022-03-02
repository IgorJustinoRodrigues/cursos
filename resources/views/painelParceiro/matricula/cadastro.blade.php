@extends('template.parceiro')
@section('title', 'Nova Matrícula')
@section('menu-matricula', 'true')


@section('header')
    <link href="{{ URL::asset('template/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('footer')
    <!-- Quill -->
    <script src="{{ URL::asset('template/vendor/jquery.mask.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
        $('.dinheiro').mask('#.##0,00', {
            reverse: true
        });


        $("#nivel").change(function() {

            var nivel = $(this).val();

            $.ajax({
                type: 'post',
                url: "{{ route('listarCursosParceiroAjax') }}",
                data: {
                    tipo: nivel,
                    _token: $("input[name='_token']").val()
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#curso').append('<option>Buscando informações...</option>');
                },
                success: function(data) {
                    $('#curso').text('');
                    $('#curso').append('<option value="">-</option>');

                    if (data.status == 1) {
                        for (i = 0; i <= data.retorno.length; i++) {
                            $('#curso').append('<option value="' + data.retorno[i].id + '">' + data
                                .retorno[i].nome + '</option>');
                        }
                    } else {
                        $('#curso').html(data.msg);
                    }

                },
                error: function() {
                    $('#curso').text('');
                    $('#curso').append(
                        '<option>Nosso sistema está passando por instabilidades, aguarde alguns instantes e tente novamente!</option>'
                    );
                }

            });

            $("#valor").val($(this).find(':selected').attr('data-valor'));
        });

        $("#nivel").trigger('change');

        function tipoPagamento() {
            var tipo_pagamento = $("#tipo_pagamento").val();

            if (tipo_pagamento == '1') {
                $(".parcelado").addClass("d-none");
            } else {
                $(".parcelado").removeClass("d-none");
            }
        }
        tipoPagamento();
    </script>

@endsection

@section('conteudo')
    <div class="col-md-12">

        <div class="d-flex align-items-center mb-4">
            <h1 class="h2 flex mr-3 mb-0">Nova Matrícula</h1>
        </div>

        <div class="card card-body">
            <div class="row">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('inserirMatriculaParceiro') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="nivel">Nível do Curso</label>
                                <select id="nivel" class="form-control custom-select" name="nivel">
                                    <option @if (old('nivel') == 1) selected @endif value="1" data-valor="45,00">
                                        Iniciante</option>
                                    <option @if (old('nivel') == 2) selected @endif value="2" data-valor="65,00">
                                        Intermediario</option>
                                    <option @if (old('nivel') == 3) selected @endif value="3" data-valor="95,00">
                                        Avançado</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="curso">Cursos</label>

                                <select class="form-control custom-select select2" id="curso" name="curso">
                                    <!--Ajax -->
                                </select>
                            </div>

                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="unidade">Unidade</label>
                                <select id="unidade" class="form-control custom-select select2" name="unidade">
                                    <option value=""></option>
                                    @foreach ($unidades as $linha)
                                        <option @if (old('unidade') == $linha->id) selected @endif value="{{ $linha->id }}">{{ $linha->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="vendedor">Vendedor</label>
                                <select id="vendedor" class="form-control custom-select select2" name="vendedor">
                                    <option value=""></option>
                                    @foreach ($vendedores as $linha)
                                        <option @if (old('vendedor') == $linha->id) selected @endif class="unidade unidade{{ $linha->unidade_id }}" value="{{ $linha->id }}">{{ $linha->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-12 mb-3">
                                <label class="form-label" for="aluno">Aluno</label>
                                <select id="aluno" class="form-control custom-select select2" name="aluno">
                                    <option value=""></option>
                                    @foreach ($alunos as $linha)
                                        <option @if (old('aluno') == $linha->id) selected @endif
                                            value="{{ $linha->id }}">{{ $linha->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label class="form-label" for="tipo_pagamento">Tipo de Pagamento</label>
                                <select id="tipo_pagamento" class="form-control custom-select" name="tipo_pagamento"
                                    onchange="tipoPagamento()">
                                    <option @if (old('tipo_pagamento') == 1) selected @endif value="1">A vista</option>
                                    <option @if (old('tipo_pagamento') == 2) selected @endif value="2">Parcelado</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3 mb-3 parcelado d-none">
                                <label class="form-label" for="quant_parcelas">Quantidade de Parcelas</label>
                                <input type="number" class="form-control" id="quant_parcelas" name="quant_parcelas_venda"
                                    min="1" max="24" step="1" value="2">
                            </div>
                            <div class="col-12 col-md-3 mb-3 parcelado d-none">
                                <label class="form-label" for="mes_inicio_pagamento">Primeiro pagamento em</label>
                                <select id="mes_inicio_pagamento" class="form-control custom-select"
                                    name="mes_inicio_pagamento">
                                    <option @if (old('mes_inicio_pagamento') == 1) selected @endif
                                        value="{{ app(App\Services\Services::class)->primeiro_pagamento(true, true, true) }}">
                                        {{ app(App\Services\Services::class)->primeiro_pagamento(true) }}</option>
                                    <option @if (old('mes_inicio_pagamento') == 2) selected @endif
                                        value="{{ app(App\Services\Services::class)->primeiro_pagamento(true, true, true, true) }}">
                                        {{ app(App\Services\Services::class)->primeiro_pagamento(true, true) }}</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-3 mb-3">
                                <label class="form-label" for="valor">Valor de Venda</label>
                                <input type="text" class="form-control dinheiro" id="valor" name="valor_venda"
                                    placeholder="Valor" value="{{ old('valor_venda') }}">
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex">
                            <div class="flex">
                                <a href="{{ route('matriculaIndex') }}" class="btn btn-default btn-wide">Voltar</a>
                            </div>
                            <button class="btn btn-success" type="submit">Inserir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

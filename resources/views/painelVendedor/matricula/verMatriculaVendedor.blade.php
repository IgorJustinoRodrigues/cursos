@extends('template.vendedor')
@section('title', 'Matrículas')
@section('menu-matricula', 'true')

@section('footer')

    <div class="modal fade" id="modalEnvio" tabindex="-1" aria-labelledby="envioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="envioLabel">Enviar Código de matrícula</h5>
                </div>
                <div class="modal-body">
                    <!-- código html-->
                    <form action="#">
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group input-group-merge">
                                <input type="email" class="form-control form-control-prepended" name="email"
                                    placeholder="Email do Aluno">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-paper-plane"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">WhatsApp</label>
                            <div class="input-group input-group-merge">
                                <input type="email" class="form-control form-control-prepended" name="whatsapp"
                                    placeholder="Whatsapp do Aluno">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-whatsapp"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Telefone</label>
                            <div class="input-group input-group-merge">
                                <input type="email" class="form-control form-control-prepended" name="contato"
                                    placeholder="Enviar matrícula por SMS">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-phone-square"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            <a href="" class="btn btn-success">Confirmar</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>

       
    </script>
@endsection


@section('conteudo')
    <input type="hidden" id="input-copy" value="Esse conteúdo foi copiado!">
    <div class="card border-left-3 border-left-success">
        <div class="card-body">
            <div class="list-group list-group-fit">
                <div class="card-header media align-items-center">
                    <div class="media-body">
                        <h1 class="card-title h2">Dados de Acesso a Matrícula </h1>
                        <div class="card-subtitle">Matrícula gerada em {{ $item->data }}</div>
                    </div>
                    <div class="media-right d-flex align-items-center">
                        <a href="javascript:window.print()" id="print" class="btn btn-flush text-muted d-print-none mr-3"><i
                                class="material-icons font-size-24pt">print</i></a>
                        <button type="button" onclick="copiar('input-copy')"
                            class="btn btn-primary btn-rounded mr-3">Copiar</button>
                        <button type="button" onclick="$('#modalEnvio').modal('show');"
                            class="btn btn-success btn-rounded">Enviar Código</button>
                    </div>
                </div>

                <div class="list-group-item">
                    <div class="form-group row mb-0">
                        <label class="col-form-label form-label col-sm-3">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">N° Matrícula Gerada</font>
                            </font>
                        </label>
                        <div class="col-sm-9 d-flex align-items-center">
                            <div class="flex">
                                <font style="vertical-align: inherit;">
                                    <font style="vertical-align: inherit;">{{ $item->ativacao }}</font>
                                </font>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="form-group row mb-0">
                        <label class="col-form-label form-label col-sm-3">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Aluno</font>
                            </font>
                        </label>
                        <div class="col-sm-9 d-flex align-items-center">
                            <div class="flex">
                                <font style="vertical-align: inherit;">
                                    @if ($item->curso != null)
                                        <font style="vertical-align: inherit;">{{ $item->aluno }}</font>
                                    @else
                                        <font style="vertical-align: inherit;">Aluno não Informado!</font>
                                    @endif
                                </font>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="list-group-item">
                    <div class="form-group row mb-0">
                        <label class="col-form-label form-label col-sm-3">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Curso</font>
                            </font>
                        </label>
                        <div class="col-sm-9 d-flex align-items-center">
                            <div class="flex">
                                <font style="vertical-align: inherit;">
                                    @if ($item->curso != null)
                                        <font style="vertical-align: inherit;">{{ $item->curso }}</font>
                                    @else
                                        <font style="vertical-align: inherit;">Curso não Informado!</font>
                                    @endif
                                </font>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="list-group-item">
                    <div class="form-group row mb-0">
                        <label class="col-form-label form-label col-sm-3">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Informação de pagamento</font>
                            </font>
                        </label>
                        <div class="col-sm-9 d-flex align-items-center">
                            <div class="flex">
                                @if ($item->tipo_pagamento == 1)
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">
                                            {{ app(App\Http\Controllers\MatriculaController::class)->tipoPagamento($item->tipo_pagamento) }}
                                            | {{ $item->valor_venda }}</font>
                                    </font>
                                @else
                                    <font style="vertical-align: inherit;">
                                        <font style="vertical-align: inherit;">
                                            {{ app(App\Http\Controllers\MatriculaController::class)->tipoPagamento($item->tipo_pagamento) }}
                                            | {{ $item->quant_parcelas }} Parcelas</font>
                                    </font>
                                @endif
                            </div>
                            <!--
                                                                                                                                        <a href="fixed-student-account-billing-payment-information.html" class="text-secondary">
                                                                                                                                            <font style="vertical-align: inherit;">
                                                                                                                                                <font style="vertical-align: inherit;">Alterar método</font>
                                                                                                                                            </font>
                                                                                                                                        </a> -->
                        </div>
                    </div>
                </div>

                <div class="list-group-item" id="solicitar">
                    <div class="form-group row mb-0">
                        <label class="col-form-label form-label col-sm-3">
                            <font style="vertical-align: inherit;">
                                <font style="vertical-align: inherit;">Solicitar Cancelamento de Matrícula</font>
                            </font>
                        </label>
                        <div class="col-sm-9">
                            <a class="btn btn-outline-secondary"
                                onclick="confirmacao('{{ route('cursoDeletar', $item->id) }}', '<h3>Realmente deseja solicitar cancelamento de matrícula ?</h3><p>{{ $item->nome }}</p>')"
                                <font style="vertical-align: inherit;">Solicitar cancelamento</font>
                                </font>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

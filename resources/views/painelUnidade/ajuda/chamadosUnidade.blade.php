@extends('template.unidade')
@section('title', 'Tela de Ajuda')
@section('menu-ajuda', 'true')

@section('footer')

@endsection

@section('conteudo')
    <div class="page ">

        <div class="container page__container p-0">
            <div class="row m-0">
                <div class="col-lg container-fluid page__container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="fixed-student-dashboard.html">Home</a></li>
                        <li class="breadcrumb-item active">Edit Account</li>
                    </ol>

                    <h1 class="h2">Meus Chamados</h1>

                    <div class="card border-left-3 border-left-danger card-2by1">
                        <div class="card-body">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    Você tem um mensagem de um chamado ainda não respondida
                                    <strong class="text-danger">Não Consigo Acessar o meu Curso</strong> Chamado: <a
                                        href="#">#8331</a>
                                </div>
                                <div class="media-right">
                                    <a href="fixed-student-pay.html" class="btn btn-success float-right">Ir para o
                                        Chamado</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card table-responsive" data-toggle="lists" data-lists-values='[
            "js-lists-values-document", 
            "js-lists-values-amount",
            "js-lists-values-status",
            "js-lists-values-date"
            ]' data-lists-sort-by="js-lists-values-document" data-lists-sort-desc="true">
                        <table class="table mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th colspan="4">
                                        <a href="javascript:void(0)" class="sort"
                                            data-sort="js-lists-values-document">Document</a>
                                        <a href="javascript:void(0)" class="sort"
                                            data-sort="js-lists-values-amount">Amount</a>
                                        <a href="javascript:void(0)" class="sort"
                                            data-sort="js-lists-values-status">Status</a>
                                        <a href="javascript:void(0)" class="sort"
                                            data-sort="js-lists-values-date">Date</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="list">

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <small class="text-uppercase text-muted mr-2">Invoice</small>
                                            <a href="fixed-student-invoice.html" class="text-body small">#<span
                                                    class="js-lists-values-document">12199</span></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center">
                                            <small class="text-uppercase text-muted mr-2">Amount</small>
                                            <small class="text-uppercase">$<span class="js-lists-values-amount">25</span>
                                                USD</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center">
                                            <small class="text-uppercase text-muted mr-2">Status</small>
                                            <i class="material-icons text-success md-18 mr-2">lens</i>
                                            <small class="text-uppercase js-lists-values-status">paid</small>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex align-items-center text-right">
                                            <small class="text-uppercase text-muted mr-2">Date</small>
                                            <small class="text-uppercase js-lists-values-date">12 Feb 2016</small>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <small class="text-uppercase text-muted mr-2">Invoice</small>
                                            <a href="fixed-student-invoice.html" class="text-body small">#<span
                                                    class="js-lists-values-document">8331</span></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center">
                                            <small class="text-uppercase text-muted mr-2">Amount</small>
                                            <small class="text-uppercase">$<span class="js-lists-values-amount">25</span>
                                                USD</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center">
                                            <small class="text-uppercase text-muted mr-2">Status</small>
                                            <i class="material-icons text-danger md-18 mr-2">lens</i>
                                            <small class="text-uppercase js-lists-values-status">unpaid</small>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex align-items-center text-right">
                                            <small class="text-uppercase text-muted mr-2">Date</small>
                                            <small class="text-uppercase js-lists-values-date">12 Jan 2016</small>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <small class="text-uppercase text-muted mr-2">Invoice</small>
                                            <a href="fixed-student-invoice.html" class="text-body small">#<span
                                                    class="js-lists-values-document">2421</span></a>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center">
                                            <small class="text-uppercase text-muted mr-2">Amount</small>
                                            <small class="text-uppercase">$<span class="js-lists-values-amount">25</span>
                                                USD</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center">
                                            <small class="text-uppercase text-muted mr-2">Status</small>
                                            <i class="material-icons text-success md-18 mr-2">lens</i>
                                            <small class="text-uppercase js-lists-values-status">paid</small>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex align-items-center text-right">
                                            <small class="text-uppercase text-muted mr-2">Date</small>
                                            <small class="text-uppercase js-lists-values-date">12 Dec 2016</small>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <ul class="pagination justify-content-center pagination-sm">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true" class="material-icons">chevron_left</span>
                                <span>Prev</span>
                            </a>
                        </li>
                        <li class="page-item active">
                            <a class="page-link" href="#" aria-label="1">
                                <span>1</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="1">
                                <span>2</span>
                            </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span>Next</span>
                                <span aria-hidden="true" class="material-icons">chevron_right</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
@endsection

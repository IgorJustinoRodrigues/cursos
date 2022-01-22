@extends('template.aluno')
@section('title', 'Matricula')

@section('footer')

@endsection

@section('conteudo')
    <div class="page ">
        <div class="container page__container p-0">
            <div class="row m-0">
                <div class="col-lg container-fluid page__container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="fixed-instructor-dashboard.html">Matrícula</a></li>
                        <li class="breadcrumb-item active">Fazer Matrícula</li>
                    </ol>

                    <div id="invoice">
                        <div class="card">
                            <div class="card-header media align-items-center">
                                <div class="media-body">
                                    <h1 class="card-title h2">Matrícula</h1>
                                    <div class="card-subtitle">Código de Ativação da Matrícula:  10003578 / 12 Jan 2019</div>
                                </div>
                                <div class="media-right d-flex align-items-center">
                                    <a href="javascript:window.print()" class="btn btn-flush text-muted d-print-none"><i
                                            class="material-icons font-size-24pt">print</i></a>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <p class="text-black-70 m-0"><strong>Nome do Aluno</strong></p>
                                        <h2>Alexander Watson</h2>
                                        <div class="text-black-50">
                                            Comprou o curso de Informática Básica<br>
                                            Pelo Vendedor Mateus
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-black-70 m-0"><strong>Loja que vendeu o Curso foi a</strong></p>
                                        <h2>Moveis Estrelas</h2>
                                        <div class="text-black-50">
                                            Tempo para ativação do Curso <br>
                                            90 dias
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card table-responsive">
                        <table class="table mb-0 table--elevated">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-top-0">Description</th>
                                    <th class="border-top-0 text-right" style="width: 120px;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="fixed-instructor-view-course.html"
                                                class="avatar avatar-4by3 avatar-sm mr-3">
                                                <img src="assets/images/gulp.png" alt="Learn Angular Fundamentals"
                                                    class="avatar-img rounded">
                                            </a>
                                            <div class="flex">
                                                <a href="fixed-instructor-view-course.html" class="text-body">
                                                    <strong>Learn Angular Fundamentals</strong>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right"><strong>&dollar;89.00 USD</strong></td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="mb-1"><strong>Basic Plan - Monthly Subscription</strong></p>
                                        <p class="text-black-50 mb-0 small">For the period of June 20, 2018 to July 20, 2018
                                        </p>
                                    </td>
                                    <td class="text-right"><strong>&dollar;9.00 USD</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Credit discount</strong></td>
                                    <td class="text-right"><strong>-&dollar;5.00 USD</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table mb-0">
                            <tfoot>
                                <tr>
                                    <td class="text-right text-black-70"><strong>Subtotal</strong></td>
                                    <td style="width: 120px;" class="text-right"><strong>&dollar;89.00 USD</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-right text-black-70"><strong>Total</strong></td>
                                    <td style="width: 120px;" class="text-right"><strong>&dollar;89.00 USD</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="px-16pt mb-4">
                        <p class="text-black-70 mb-8pt"><strong>Invoice paid</strong></p>
                        <div class="d-flex">
                            <div class="mr-3">
                                <img src="assets/images/visa.svg" alt="visa" width="38" />
                            </div>
                            <div class="flex text-black-50">
                                You don’t need to take further action. Your credit card Visa ending in 2819 has been charged
                                on January 12, 2019.
                            </div>
                        </div>
                    </div>
                </div>
                <div id="page-nav" class="col-lg-auto page-nav">
                    <div data-perfect-scrollbar>
                        <div class="page-section pt-lg-32pt">
                            <nav class="nav page-nav__menu">
                                <a href="fixed-instructor-invoice.html" class="nav-link active">View Invoice</a>
                                <a href="fixed-instructor-edit-invoice.html" class="nav-link">Edit Invoice</a>
                                <a href="fixed-instructor-invoice-settings.html" class="disabled nav-link">Invoice
                                    Settings</a>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container page__container">
            <div class="footer">
                Copyright &copy; 2016 - <a
                    href="http://themeforest.net/item/learnplus-learning-management-application/15287372?ref=mosaicpro">Purchase
                    LearnPlus</a>
            </div>
        </div>
    </div>

@endsection

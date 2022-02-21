@extends('template.vendedor')
@section('title', 'Painel de Vendedor')

@section('footer')
    <!-- Global Settings -->
    <script src="{{ URL::asset('template/js/settings.js') }}"></script>

    <!-- Moment.js -->
    <script src="{{ URL::asset('template/vendor/moment.min.js') }}"></script>
    <script src="{{ URL::asset('template/vendor/moment-range.js') }}"></script>

    <!-- Chart.js -->
    <script src="{{ URL::asset('template/vendor/Chart.min.js') }}"></script>
    <script src="{{ URL::asset('template/js/chartjs.js') }}"></script>


 
                            <script>
                                var data = {
                                    labels: [
                                        @for ($i = count($grafico7dias) - 1; $i >= 0; $i--)
                                            "{{ $grafico7dias[$i]->created_at->format('d/m') }}",
                                        @endfor
                                    ],
                                    datasets: [{
                                        label: "Performance",
                                        data: [
                                            @for ($i = count($grafico7dias) - 1; $i >= 0; $i--)
                                                {{ $grafico7dias[$i]->total }},
                                            @endfor

                                        ]
                                    }]
                                }

                                Charts.create('#performanceChart', 'line', '', data)
                            </script>
                            
                      
@endsection

@section('conteudo')

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <div class="flex">
                        <h4 class="card-title">VENDAS DOS ULTIMOS 7 DIAS</h4>
                        <p class="card-subtitle"></p>
                    </div>
                    <i class="material-icons text-muted ml-2">trending_up</i>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="performanceChart" class="chart-canvas" data-chart-prefix=""
                            data-chart-suffix=""></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <div class="flex">
                        <h4 class="card-title">
                            <font style="vertical-align: inherit;"> 
                                <font style="vertical-align: inherit;">CURSOS MAIS VENDIDOS DO MÊS</font>
                            </font>
                        </h4>
                    </div>
                </div>
                <ul class="list-group list-group-fit mb-0">
                    @foreach ($ranking as $Ranklinha)
                        <li class="list-group-item">
                            <div class="media align-items-center">
                                <div class="media-body">
                                    <a href="fixed-instructor-course-edit.html" class="text-body"><strong>
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">{{$Ranklinha->curso}}</font>
                                            </font>
                                        </strong></a>
                                </div>
                                <div class="media-right">
                                    <div class="text-center">
                                        <span class="badge badge-pill badge-dark">
                                            <font style="vertical-align: inherit;">
                                                <font style="vertical-align: inherit;">{{$Ranklinha->total}}</font>
                                            </font>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection

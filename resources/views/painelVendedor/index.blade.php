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
                @for($i = count($grafico7dias) - 1 ; $i >= 0; $i--)
                    "{{ $grafico7dias[$i]->created_at->format('d/m') }}",
                @endfor
            ],
            datasets: [{
                label: "Performance",
                data: [
                    @for($i = count($grafico7dias) - 1 ; $i >= 0; $i--)
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
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <div class="flex">
                        <h4 class="card-title">Vendas da Semana</h4>
                        <p class="card-subtitle">vendas nos últimos 7 dias</p>
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
        <div class="col-lg-5">

        </div>
    </div>

@endsection

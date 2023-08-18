@extends('adminlte::page')

@section('title', 'ParteSys')

@section('content_header')
    <h1 style="text-align: center;">INFORME ESTADÍSTICO</h1>
@stop

@section('content')

    @livewire('informe-index')

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop
@vite('resources/js/app.js')
@section('js')
    {{-- <script> console.log('Hi!'); </script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script type="text/javascript">
        let myChart;
        let myChart2;
        let myChart3;
        window.addEventListener('refreshChart', event => {
            var labels = event.detail.names;
            var totals = event.detail.totals;
            var balance = event.detail.balance;
            var percent = event.detail.percent;


            if (myChart && myChart2 && myChart3) {
                myChart.destroy();
                myChart2.destroy();
                myChart3.destroy();
            }


            const data = {
                labels: labels,
                datasets: [{
                    label: 'Total Gastos por Sector',
                    backgroundColor: ['rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    borderColor: ['rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    data: totals,
                }]
            };

            const data2 = {
                labels: labels,
                datasets: [{
                    label: 'Porcentaje de Presupuesto Gastado',
                    backgroundColor: ['rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    borderColor: ['rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    data: percent,
                }]
            };

            const data3 = {
                labels: labels,
                datasets: [{
                    label: 'Saldo Disponible por Sector',
                    backgroundColor: ['rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    borderColor: ['rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    data: balance,
                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
                options: {}
            };

            const config2 = {
                type: 'polarArea',
                data: data2,
                options: {
                    scales: {
                        r: {
                            min: 0,
                            max: 100,
                            beginAtZero: true,
                           
                        },
                        
                    }
                }
            };

            const config3 = {
                type: 'bar',
                data: data3,
                options: {
                    
                }
            };

            myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
            myChart2 = new Chart(
                document.getElementById('myChart2'),
                config2
            );
            myChart3 = new Chart(
                document.getElementById('myChart3'),
                config3
            );
        })
    </script>


@stop
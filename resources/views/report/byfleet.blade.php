@extends('layouts.layout')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
         <div class="col-lg-12">
             <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Monthly Sales Report {{ $fleet->model }} {{ $fleet->license_plate }}</h5>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
          <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sales For {{ $fleet->model }} {{ $fleet->license_plate }}</h5>
                    <div class="table-responsive">
                        {{-- <div class="d-none d-md-block table-responsive"> --}}
                        <table id="tableData" class="datatable table table-striped">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Pickup Date</th>
                                    <th>Rental Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($sales_by_month) --}}
                                @foreach ($rentals as $rental)
                                    <tr>
                                        <td>{{ $rental['customer_name'] }}</td>
                                        <td>{{ $rental['pickup_date'] }} <br>
                                            {{ $rental['pickup_time'] }}</td>
                                        </td>
                                        <td>RM {{ number_format($rental['rental_amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($sales_by_month->pluck('month')),
                    datasets: [{
                        label: 'Sales (RM)',
                        data: @json($sales_by_month->pluck('total')),
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Monthly Sales'
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'end',
                            color: '#333',
                            font: {
                                weight: 'bold',
                                size: 12
                            },
                            formatter: function(value) {
                                return 'RM ' + value;
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Sales (RM)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });
        });
    </script>
@endsection

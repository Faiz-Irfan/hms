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
                    <h5 class="card-title">Monthly Sales Report</h5>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Weekly Sales Report</h5>
                    <div class="mb-3">
                        <label for="monthFilter" class="form-label">Select Month:</label>
                        <select id="monthFilter" class="form-select"
                            style="width:auto;display:inline-block">
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}"
                                    @if (request('month', now()->month) == $m) selected @endif>{{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                        <button id="filterBtn" class="btn btn-primary ms-2">Filter</button>
                    </div>
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sales By Car {{ \Carbon\Carbon::now()->year }}</h5>
                    <div class="table-responsive">
                        {{-- <div class="d-none d-md-block table-responsive"> --}}
                        <table id="tableData" class="datatable table table-striped">
                            <thead>
                                <tr>
                                    <th>Fleet</th>
                                    <th>Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($sales_by_month) --}}
                                @foreach ($sales_by_car as $item)
                                    <tr>
                                        <td><a href="{{ route('report.byfleet', $item->id) }}">{{ $item->model }}
                                                {{ $item->license_plate }}</a></td>
                                        <td>RM {{ $item->total }}
                                        </td>
                                        {{-- <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary" type="button" data-toggle="dropdown">
                                                    <i class="bi bi-grip-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('deposit.show', $item->depo_id) }}">Deposit</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('rental.show', $item->id) }}">Show</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('rental.edit', $item->id) }}">Edit</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('rental.destroy', $item->id) }}">Delete</a>
                                                </div>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Export Sales</h5>
                    <form action="{{ route('export.rental') }}" method="GET" class="row g-2 align-items-end mb-3">
                        <div class="col-auto">
                            <label for="start_date" class="form-label mb-0">Start Date:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <div class="col-auto">
                            <label for="end_date" class="form-label mb-0">End Date:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success">Export Sales</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.register(window.ChartDataLabels);
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
                                size: 14
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

            // Weekly sales chart
            const weekLabels = ['Week 1 (1-7)', 'Week 2 (8-14)', 'Week 3 (15-21)', 'Week 4 (22-31)'];
            const weekData = @json($sales_by_week);
            const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
            const weekChart = new Chart(weeklyCtx, {
                type: 'bar',
                data: {
                    labels: weekLabels,
                    datasets: [{
                        label: 'Weekly Sales (RM)',
                        data: weekData,
                        backgroundColor: 'rgba(255, 159, 64, 0.5)',
                        borderColor: 'rgba(255, 159, 64, 1)',
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
                            text: 'Weekly Sales ({{ \Carbon\Carbon::now()->format("F") }})'
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'end',
                            color: '#333',
                            font: {
                                weight: 'bold',
                                size: 14
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
                                text: 'Week Range'
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });

            document.getElementById('filterBtn').addEventListener('click', function() {
                const month = document.getElementById('monthFilter').value;
                const url = new URL(window.location.href);
                url.searchParams.set('month', month);
                window.location.href = url.toString();
            });
        });
    </script>
@endsection
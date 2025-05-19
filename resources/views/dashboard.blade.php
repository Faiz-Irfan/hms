@extends('layouts.layout')
@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    {{-- Sales Card --}}
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Sales <span>| This Month</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $data['sales'] }}</h6>
                                        {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span
                                            class="text-muted small pt-2 ps-1">increase</span> --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Rental Card -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Rental <span>| This Month</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-car-front"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $data['rental'] }}</h6>
                                        {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span
                                            class="text-muted small pt-2 ps-1">increase</span> --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Rental Card -->
                    <!-- Claim Card -->
                    <div class="col-xxl-3 col-md-6">
                        <a href="" class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Claims</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-clipboard-minus"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $data['claim'] }}</h6>
                                        {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span
                                            class="text-muted small pt-2 ps-1">increase</span> --}}

                                    </div>
                                </div>
                            </div>
                        </a>
                    </div><!-- End Sales Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-3 col-xl-12">
                        <div class="card info-card customers-card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Customers <span>| This Year</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $data['customer'] }}</h6>
                                        {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span
                                            class="text-muted small pt-2 ps-1">decrease</span> --}}
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- End Customers Card -->

                    <!-- Available Fleet -->
                    <div class="col-md-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Fleet Available <span>| Today</span></h5>
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Model</th>
                                            <th scope="col">Plate</th>
                                            <th scope="col">Color</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['car'] as $item)
                                            {{-- {{ $item }} --}}
                                            <tr>
                                                <td>{{ $item->model }}</td>
                                                <td><a href="#" class="text-primary">{{ $item->license_plate }}</a>
                                                </td>
                                                <td>{{ $item->color }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                    <!-- End Available Fleet -->

                    <!-- Check Fleet Availability -->
                    <div class="col-md-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Check Fleet Availability <span>| Today</span></h5>
                                <form action="{{ route('check.availability') }}" method="GET">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label for="pickup_date" class="form-label">Pickup Date</label>
                                            <input type="date" class="form-control" id="pickup_date"
                                                name="pickup_date" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="pickup_time" class="form-label">Pickup Time</label>
                                            <select class="form-select" name="pickup_time" required id="pickup_time">
                                                @php
                                                    $start = strtotime('00:00');
                                                    $end = strtotime('23:45');
                                                    $interval = 15 * 60; // 15 minutes
                                                @endphp
                                                @for ($time = $start; $time <= $end; $time += $interval)
                                                    <option value="{{ date('H:i', $time) }}">
                                                        {{ date('h:i A', $time) }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="return_date" class="form-label">Return Date</label>
                                            <input type="date" class="form-control" id="return_date"
                                                name="return_date" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="return_time" class="form-label">Return Time</label>
                                            <select class="form-select" name="return_time" required id="return_time">
                                                @for ($time = $start; $time <= $end; $time += $interval)
                                                    <option value="{{ date('H:i', $time) }}">
                                                        {{ date('h:i A', $time) }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Check Availability</button>
                                        </div>
                                    </div>
                                </form>

                                @if (isset($availableFleets))
                                    <div class="mt-4">
                                        <h6>Available Vehicles:</h6>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Model</th>
                                                    <th>License Plate</th>
                                                    <th>Color</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($availableFleets as $fleet)
                                                    <tr>
                                                        <td>{{ $fleet->model }}</td>
                                                        <td>{{ $fleet->license_plate }}</td>
                                                        <td>{{ $fleet->color }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- End Check Fleet Availability -->

                    <!-- Pickup Today -->
                    <div class="col-md-12">
                        <div class="card recent-sales overflow-auto">
                            {{-- <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div> --}}
                            <div class="card-body">
                                <h5 class="card-title">Pickup <span>| Today</span></h5>
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Fleet</th>
                                            <th scope="col">Pickup Time</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['rentalToday'] as $item)
                                            {{-- {{ $item }} --}}
                                            <tr>
                                                <th scope="row"><a href="#">{{ $loop->index + 1 }}</a></th>
                                                <td><a
                                                        href="{{ route('rental.show', [$item->id]) }}">{{ $item->customer->name }}</a>
                                                </td>
                                                <td>{{ $item->fleet->model }} -
                                                    {{ $item->fleet->license_plate }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->pickup_time)->format('h:i A') }}</td>
                                                <td>
                                                    @if ($item->payment->payment_status == 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @else
                                                        <span class="badge bg-danger">Unpaid</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        {{-- <tr>
                                            <th scope="row"><a href="#">#2147</a></th>
                                            <td>Bridie Kessler</td>
                                            <td><a href="#" class="text-primary">Blanditiis dolor omnis
                                                    similique</a></td>
                                            <td>$47</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><a href="#">#2644</a></th>
                                            <td>Angus Grady</td>
                                            <td><a href="#" class="text-primar">Ut voluptatem id earum et</a></td>
                                            <td>$67</td>
                                            <td><span class="badge bg-danger">Rejected</span></td>
                                        </tr>
                                        --}}
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Pickup Today -->
                    <!-- Return Today -->
                    <div class="col-md-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Return <span>| Today</span></h5>
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Fleet</th>
                                            <th scope="col">Return Time</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['returnToday'] as $item)
                                            {{-- {{ $item }} --}}
                                            <tr>
                                                <th scope="row"><a href="#">{{ $loop->index + 1 }}</a></th>
                                                <td><a href="{{ route('rental.show', [$item->id]) }}"
                                                        class="text-primary">
                                                        {{ $item->customer->name }}</a></td>
                                                <td>{{ $item->fleet->model }} - {{ $item->fleet->license_plate }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->return_time)->format('h:i A') }}</td>
                                                <td>
                                                    @if ($item->payment->payment_status == 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @else
                                                        <span class="badge bg-danger">Unpaid</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- End Return Today -->
                </div>
            </div>

        </div>
    </section>
@endsection

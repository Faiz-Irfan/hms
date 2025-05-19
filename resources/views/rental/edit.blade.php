@extends('layouts.layout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{-- @dd($fleet) --}}

                        <h5 class="card-title">Edit Rental</h5>
                        <!-- Vertical Form -->
                        @php
                            $userId = session('user_id');
                        @endphp
                        <form id="rentalForm" action="{{ route('rental.update', $rental->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <input type="hidden" class="" id="staff_id" name="staff_id"
                                    value="{{ $userId }}">
                                <input type="hidden" class="" id="customer_id" name="customer_id"
                                    value="{{ $rental->customer_id }}">
                                {{-- Customer Detail --}}
                                <div class="col-md-6">
                                    <h4>Customer Info</h4>
                                    <div class="col-md-12">
                                        <label for="name" class="form-label">Customer Name</label>
                                        <input type="text" placeholder="Ahmad Irfan" class="form-control" name="name"
                                            id="name" value="{{ old('name', $rental->customer->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" placeholder="ahmad@graduate.utm.my" class="form-control"
                                                name="email" id="email"
                                                value="{{ old('email', $rental->customer->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="race" class="form-label">Race / Nationality</label>
                                            <select class="form-control" name="race" id="race"
                                                value="{{ old('race', $rental->customer->race) }}">
                                                <option value="Malay">Malay</option>
                                                <option value="China">China</option>
                                                <option value="India">India</option>
                                                <option value="Others">Others</option>
                                            </select>
                                            @error('race')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="ic" class="form-label">IC Number/Passport </label>
                                            <input type="text" placeholder="000627101198" class="form-control"
                                                name="ic" id="ic"
                                                value="{{ old('ic', $rental->customer->ic) }}">
                                            @error('ic')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="matric" class="form-label">Matric</label>
                                            <input type="text" placeholder="A24EC0021" class="form-control"
                                                name="matric" id="matric"
                                                value="{{ old('matric', $rental->customer->matric) }}">
                                            @error('matric')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Mobile Number </label>
                                            <input type="number" class="form-control" name="phone" id="phone"
                                                value="{{ old('phone', $rental->customer->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="college" class="form-label">College </label>
                                            <select class="form-control" name="college" id="college">
                                                @foreach ($colleges as $college)
                                                    <option value="{{ $college }}"
                                                        {{ old('college', $rental->customer->college) == $college ? 'selected' : '' }}>
                                                        {{ $college }}</option>
                                                @endforeach
                                            </select>
                                            @error('college')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="faculty" class="form-label">Faculty</label>
                                            <select class="form-control" name="faculty" id="faculty">
                                                <option value="">-- Select Faculty --</option>
                                                @foreach ($faculties as $faculty)
                                                    <option value="{{ $faculty }}"
                                                        {{ old('faculty', $rental->customer->faculty) == $faculty ? 'selected' : '' }}>
                                                        {{ $faculty }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('faculty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="address" class="form-label">Address </label>
                                            <input type="text" class="form-control" name="address" id="address"
                                                value="{{ old('address', $rental->customer->address) }}">
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row pt-2">
                                        <h5>Bank Details</h5>
                                        <div class="col-md-6">
                                            <label for="bank" class="form-label">Bank</label>
                                            <select class="form-control" name="bank" id="bank">
                                                <option value="">-- Select Bank --</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank }}"
                                                        {{ $rental->customer->bank == $bank ? 'selected' : '' }}>
                                                        {{ $bank }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="acc_num" class="form-label"> Account Number</label>
                                            <input type="text" placeholder="" class="form-control" name="acc_num"
                                                id="acc_num" value="{{ old('acc_num', $rental->customer->acc_num) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="acc_num_name" class="form-label"> Account Owner</label>
                                            <input type="text" placeholder="" class="form-control"
                                                name="acc_num_name" id="acc_num_name"
                                                value="{{ old('acc_num_name', $rental->customer->acc_num_name) }}">
                                            @error('acc_num_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- Rental Detail --}}
                                <div class="col-6">
                                    <h4>Rental Info</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="pickup_date" class="form-label">Pickup Date</label>
                                            <input type="date" class="form-control" name="pickup_date"
                                                id="pickup_date"
                                                value="{{ old('pickup_date', date('Y-m-d', strtotime($rental->pickup_date))) }}">
                                            @error('pickup_date')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="return_date" class="form-label">Return Date</label>
                                            <input type="date" class="form-control" name="return_date"
                                                id="return_date"
                                                value="{{ old('return_date', date('Y-m-d', strtotime($rental->return_date))) }}">
                                            @error('return_date')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @php
                                            // Generate times from 12:00 AM to 11:45 PM in 15-minute intervals
                                            $times = [];
                                            $startTime = strtotime('00:00'); // Start at midnight
                                            $endTime = strtotime('23:45'); // End at 11:45 PM
                                            while ($startTime <= $endTime) {
                                                $value = date('H:i', $startTime); // Value in 24-hour format
                                                $display = date('h:i A', $startTime); // Display in 12-hour format
                                                $times[] = ['value' => $value, 'display' => $display];
                                                $startTime = strtotime('+15 minutes', $startTime);
                                            }
                                        @endphp
                                        <div class="col-md-6">
                                            <label for="pickup_time" class="form-label">Pickup Time</label>
                                            <select class="form-select" name="pickup_time" required="required"
                                                id="pickup_time">
                                                @foreach ($times as $time)
                                                    <option value="{{ $time['value'] }}"
                                                        {{ $time['value'] == date('H:i', strtotime($rental->pickup_time)) ? 'selected' : '' }}>
                                                        {{ $time['display'] }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="return_time" class="form-label">Return Time</label>
                                            <select class="form-select" name="return_time" required="required"
                                                id="return_time">
                                                @foreach ($times as $time)
                                                    <option value="{{ $time['value'] }}"
                                                        {{ $time['value'] == date('H:i', strtotime($rental->return_time)) ? 'selected' : '' }}>
                                                        {{ $time['display'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="fleet_id" class="form-label">Plate Number</label>
                                            {{-- <input type="text" class="form-control" name="fleet_id" id="fleet_id"
                                                value="{{ $rental->fleet->id }}" readonly> --}}
                                            <select class="form-control @error('fleet_id') is-invalid @enderror"
                                                name="fleet_id" id="fleet_id" value="">
                                                <option value="">-- Select a Vehicle --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="pickup_location" class="form-label"> Pickup Location</label>
                                            <input type="text" class="form-control" name="pickup_location"
                                                id="pickup_location" value="{{ $rental->pickup_location }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="return_location" class="form-label">Return Location</label>
                                            <input type="text" class="form-control" name="return_location"
                                                id="return_location" value="{{ $rental->return_location }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="note" class="form-label">Note</label>
                                            <textarea name="note" class="form-control" id="note" cols="30" rows="5" value="">{{ $rental->note }}</textarea>
                                        </div>
                                        <div class="col-6">
                                            <label for="destination" class="form-label">Destination</label>
                                            <input type="text" class="form-control" name="destination"
                                                id="destination" value="{{ $rental->destination }}">
                                        </div>
                                    </div>
                                    <div class="row pt-2">
                                        <h5>Payment Details</h5>
                                        <div class="col-6">
                                            <label for="payment_status" class="form-label">Payment Status</label>
                                            <select class="form-control" name="payment_status" id="payment_status"
                                                value="{{ $rental->payment->payment_status }}">
                                                <option value="unpaid"
                                                    {{ $rental->payment->payment_status == 'unpaid' ? 'selected' : '' }}>
                                                    Unpaid</option>
                                                <option value="paid"
                                                    {{ $rental->payment->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                                </option>
                                                <option value="partially_paid"
                                                    {{ $rental->deposit->status == 'partially_paid' ? 'selected' : '' }}>
                                                    Partially
                                                    Paid
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="rental_amount" class="form-label">Rental Amount</label>
                                            <input type="number" class="form-control" name="rental_amount"
                                                id="rental_amount" value="{{ $rental->payment->rental_amount }}">
                                        </div>
                                        {{-- <div class="col-6">
                                            <label for="total_amount" class="form-label">Total Amount</label>
                                            <input type="number" class="form-control" name="total_amount"
                                                id="total_amount" value="{{ $rental->total_amount }}">
                                        </div> --}}
                                        @if (isset($rental->payment->proof))
                                            <div class="col-4 d-flex align-items-end pt-2">
                                                <a class="btn btn-light" href="{{ asset($rental->payment->proof) }}"
                                                    target="_blank">View</a>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <label for="inputNumber" class="col-sm col-form-label">Payment
                                                    Proof</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" name="payment_proof" id="payment_proof"
                                                        type="file" id="formFile">
                                                </div>
                                                @error('payment_proof')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="depo_amount" class="form-label">Depo Amount</label>
                                            <input type="number" class="form-control" name="depo_amount"
                                                id="depo_amount" value="{{ $rental->deposit->amount }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="depo_date" class="form-label">Depo Date</label>
                                            <input type="date" class="form-control" name="depo_date" id="depo_date"
                                                value="{{ $rental->deposit->date }}">
                                        </div>
                                        <div class="col-6">
                                            <label for="depo_status" class="form-label">Deposit Status</label>
                                            <select class="form-control" name="depo_status" id="depo_status">
                                                <option value="unpaid"
                                                    {{ $rental->deposit->status == 'Unpaid' ? 'selected' : '' }}>
                                                    Unpaid</option>
                                                <option value="paid"
                                                    {{ $rental->deposit->status == 'Paid' ? 'selected' : '' }}>Paid
                                                </option>

                                            </select>
                                        </div>
                                        @if (isset($rental->deposit->proof))
                                            <div class="col-4 d-flex align-items-end">
                                                <a class="btn btn-light" href="{{ asset($rental->deposit->proof) }}"
                                                    target="_blank">View</a>
                                            </div>
                                        @else
                                            {{-- Add Proof Logic --}}
                                        @endif

                                    </div>
                                </div>

                            </div>

                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    {{-- <script>
        let debounceTimer;

        // Function to check available vehicles
        function checkAvailableVehicles() {
            const pickupDate = $('#pickup_date').val();
            const pickupTime = $('#pickup_time').val();
            const returnDate = $('#return_date').val();
            const returnTime = $('#return_time').val();

            if (pickupDate && pickupTime && returnDate && returnTime) {
                $.ajax({
                    url: '/available-vehicles',
                    method: 'GET',
                    data: {
                        pickup_date: pickupDate,
                        pickup_time: pickupTime,
                        return_date: returnDate,
                        return_time: returnTime
                    },
                    success: function(response) {
                        $('#fleet_id').empty();
                        $('#fleet_id').append('<option value="">-- Select a Vehicle --</option>');
                        $.each(response, function(id, licensePlate) {
                            $('#fleet_id').append(
                                `<option value="${id}" ${id == {{ $rental->fleet_id }} ? 'selected' : ''}>${licensePlate}</option>`
                            );
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        }

        // Check available vehicles on page load
        $(document).ready(function() {
            checkAvailableVehicles();
        });

        // Check available vehicles when dates/times change
        $('#rentalForm').on('change', '#pickup_date, #pickup_time, #return_date, #return_time', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(checkAvailableVehicles, 300);
        });
    </script> --}}
@section('script')
    <script>
        let debounceTimer;
        const currentFleetId = {{ $rental->fleet_id }}; // Store the current fleet_id

        function checkAvailableVehicles() {
            const pickupDate = $('#pickup_date').val();
            const pickupTime = $('#pickup_time').val();
            const returnDate = $('#return_date').val();
            const returnTime = $('#return_time').val();

            if (pickupDate && pickupTime && returnDate && returnTime) {
                $.ajax({
                    url: '/available-vehicles',
                    method: 'GET',
                    data: {
                        pickup_date: pickupDate,
                        pickup_time: pickupTime,
                        return_date: returnDate,
                        return_time: returnTime,
                        current_rental_id: {{ $rental->id }} // Add current rental ID
                    },
                    success: function(response) {
                        const fleetSelect = $('#fleet_id');
                        fleetSelect.empty();
                        fleetSelect.append('<option value="">-- Select a Vehicle --</option>');

                        console.log(response);

                        // First, add available vehicles
                        $.each(response, function(id, licensePlate) {
                            $('#fleet_id').append(
                                `<option value="${id}" ${id == {{ $rental->fleet_id }} ? 'selected' : ''}>${licensePlate}</option>`
                            );
                        });

                        // Then, check if current vehicle is in the list
                        let currentVehicleExists = false;
                        $('#fleet_id option').each(function() {
                            if ($(this).val() == currentFleetId) {
                                currentVehicleExists = true;
                                return false; // break the loop
                            }
                        });
                        // $.each(response, function(index, vehicle) {
                        //     const selected = vehicle.id == currentFleetId ? 'selected' : '';
                        //     fleetSelect.append(
                        //         `<option value="${vehicle.id}" ${selected}>
                    //         ${vehicle.model} - ${vehicle.license_plate}
                    //     </option>`
                        //     );
                        // });

                        // If current vehicle is not in the list, fetch and add it
                        if (!currentVehicleExists) {
                            $.get(`/fleet-detail/${currentFleetId}`, function(currentVehicle) {
                                $('#fleet_id').append(
                                    `<option value="${currentFleetId}" selected> ${currentVehicle.license_plate} </option>`
                                );
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            }
        }

        // Check available vehicles on page load
        $(document).ready(function() {
            checkAvailableVehicles();
        });

        // Check available vehicles when dates/times change
        $('#rentalForm').on('change', '#pickup_date, #pickup_time, #return_date, #return_time', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(checkAvailableVehicles, 300);
        });
    </script>

@endsection

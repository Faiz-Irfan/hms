@extends('layouts.layout')
@section('content')
    <div class="container">
        {{-- @if ($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif --}}
        <!-- Alert -->
        @if ($message = Session::get('success'))
            <div class="alert alert-success" role="alert">
                <button aria-label="Close" class="btn-close float-end" data-bs-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger" role="alert">
                <button aria-label="Close" class="btn-close float-end" data-bs-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <!-- End Alert -->
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
                <h5 class="card-title">Claims</h5>
                @php
                    $userId = session('user_id');
                @endphp
                <!-- Default Tabs -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="members-tab" data-bs-toggle="tab" data-bs-target="#members"
                            type="button" role="tab" aria-controls="members" aria-selected="true">Member's
                            Rental</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="depo-tab" data-bs-toggle="tab" data-bs-target="#depo" type="button"
                            role="tab" aria-controls="depo" aria-selected="false">Depo Morning</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="extra-tab" data-bs-toggle="tab" data-bs-target="#extra" type="button"
                            role="tab" aria-controls="extra" aria-selected="false">Extra Job</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="claim-tab" data-bs-toggle="tab" data-bs-target="#claim" type="button"
                            role="tab" aria-controls="claim" aria-selected="false">Staff
                            Claim</button>
                    </li>
                </ul>
                <div class="tab-content pt-2" id="myTabContent">
                    {{-- Member Rental --}}
                    <div class="tab-pane fade show active" id="members" role="tabpanel" aria-labelledby="members-tab">
                        <form action="{{ route('claim.store', ['id' => 'members']) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="" id="staff_id" name="staff_id" value="{{ $userId }}">

                            <div class="col-md-6">
                                <label for="rental_id" class="form-label">Rental ID</label>
                                <input type="number" class="form-control" name="rental_id" id="rental_id">
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control date" name="date" id="date">
                            </div>
                            <div class="col-md-6">
                                <label for="details" class="form-label">Remarks</label>
                                <input type="text" class="form-control" name="details" id="details">
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">Submit Claim</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                    {{-- Morning Depo --}}
                    <div class="tab-pane fade" id="depo" role="tabpanel" aria-labelledby="depo-tab">
                        <form action="{{ route('claim.store', ['id' => 'depo']) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="" id="staff_id" name="staff_id"
                                value="{{ $userId }}">

                            <div class="col-md-6">
                                <label for="rental_id" class="form-label">Rental ID</label>
                                <input type="number" class="form-control" name="rental_id" id="rental_id"
                                    value=" {{ old('rental_id') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Deduction</label>
                                <input type="number" class="form-control" placeholder="RM" name="amount"
                                    id="amount" value=" {{ old('amount') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control date" name="date" id="date-morning">
                            </div>
                            <div class="col-md-6">
                                <label for="details" class="form-label">Remarks</label>
                                <input type="text" class="form-control" name="details" id="details"
                                    value="{{ old('details') }}">
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">Submit Claim</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                    {{-- Extra Jobs --}}
                    <div class="tab-pane fade" id="extra" role="tabpanel" aria-labelledby="extra-tab">
                        <form action="{{ route('claim.store', ['id' => 'extra']) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="" id="staff_id" name="staff_id"
                                value="{{ $userId }}">
                            {{-- <input type="hidden" class="" id="claim_type_id" name="claim_type_id" value={{$claimTypeIdE}}> --}}

                            <div class="col-md-6">
                                <label for="plate_number" class="form-label">Plate</label>
                                <select class="form-control" name="plate_number" id="plate_number">
                                    @foreach ($fleet as $car)
                                        <option value="{{ $car->license_plate }}">{{ $car->license_plate }}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" class="form-control" name="plate_number" id="plate_number" > --}}
                            </div>
                            <div class="col-md-6">
                                <label for="details" class="form-label">Details</label>
                                <input type="text" class="form-control" name="details" id="details">
                            </div>
                            <div class="col-md-6">
                                <label for="destination" class="form-label">Destination</label>
                                <input type="text" class="form-control" name="destination" id="destination">
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" name="date-extra" id="date-extra">
                            </div>
                            <div class="col-md-6">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" class="form-control" name="time" id="time">
                            </div>
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Comission</label>
                                <input type="number" placeholder="RM" class="form-control" name="amount"
                                    id="amount">
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">Submit Claim</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                    {{-- Staff Claim --}}
                    <div class="tab-pane fade" id="claim" role="tabpanel" aria-labelledby="claim-tab">
                        <form action="{{ route('claim.store', ['id' => 'claim']) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="" id="staff_id" name="staff_id"
                                value="{{ $userId }}">
                            <div class="col-md-6">
                                <label for="details" class="form-label">Claim Detail</label>
                                <input type="text" class="form-control" name="details" id="details">
                            </div>
                            <div class="col-md-6">
                                <label for="plate_number" class="form-label">Plate</label>
                                <select class="form-control" name="plate_number" id="plate_number">
                                    @foreach ($fleet as $car)
                                        <option value="{{ $car->license_plate }}">{{ $car->license_plate }}</option>
                                    @endforeach
                                    <option value="None">None</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" name="date-claim" id="date-claim">
                            </div>
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" name="amount" id="amount"
                                    step="0.01">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="file">Proof Receipt</label><br>
                                <input type="file" class="form-control-file" id="receipt" name="receipt" required>
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">Submit Claim</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div><!-- End Default Tabs -->

            </div>
        </div>
        {{-- <div class="row justify-content-center">
            <div class="col-lg-6">
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
                        <h5 class="card-title">New Claim Form</h5>
                        <!-- Vertical Form -->
                        

                    </div>
                </div>
            </div>
        </div> --}}

    </div>
@endsection
@section('script')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script>
        $(function() {
            // $( "#date" ).datepicker();
            $('.date').datepicker({
                dateFormat: 'yy-mm-dd'
            }).val();

            $('#date-extra').datepicker({
                dateFormat: 'yy-mm-dd'
            }).val();

            $('#date-claim').datepicker({
                dateFormat: 'yy-mm-dd'
            }).val();
        });
    </script>
@endsection

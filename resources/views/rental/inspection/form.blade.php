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
                        @php
                            $userId = session('user_id');
                        @endphp
                        <h5 class="card-title">Inspection Form</h5>
                        <form action="{{ route('inspection.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="" name="staff_id" id="staff_id" value="{{ $userId }}">
                            <input type="hidden" class="" name="rental_id" id="rental_id"
                                value="{{ $id }}">
                            <input type="hidden" class="" name="type" id="type" value="{{ $type }}">
                            <div class="row">
                                <div class="col">
                                    <div class="col-md-6">
                                        <label for="remarks" class="form-label">Pickup Time</label>
                                        <input type="time" class="form-control" name="pickup_time" id="pickup_time"
                                            value="{{ $pickup_time }}" disabled readonly>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="text" class="form-label">Parts</label>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" value="Bluetooth Device">
                                                <label class="form-check-label" for="parts[]">
                                                    Bluetooth Device
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" value="Power Outlet">
                                                <label class="form-check-label" for="parts[]">
                                                    Power Outlet
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" checked="" value="Infotainment System">
                                                <label class="form-check-label" for="parts[]">
                                                    Infotainment System
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" checked="" value="Carpet">
                                                <label class="form-check-label" for="parts[]">
                                                    Carpet
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" checked="" value="Spare Tyre">
                                                <label class="form-check-label" for="parts[]">
                                                    Spare Tyre
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" checked="" value="Car Toolkit">
                                                <label class="form-check-label" for="parts[]">
                                                    Car Toolkit
                                                </label>
                                            </div>
                                        </div>
                                        {{-- <input type="text" class="form-control" name="parts" id="parts"> --}}
                                    </div>
                                    <div class="col-md-12">
                                        <label for="mileage" class="form-label">Mileage</label>
                                        {{-- <input type="number" class="form-control" name="mileage" id="mileage"> --}}
                                        <div class="input-group mb-3">
                                            <input type="number" name="mileage" class="form-control" placeholder="Mileage"
                                                aria-label="Mileage" aria-describedby="basic-addon2" value="">
                                            <span class="input-group-text" id="basic-addon2">KM</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="fuel" class="form-label">Fuel</label>
                                        <div class="input-group mb-3">
                                            <input type="number" name="fuel" class="form-control" placeholder="Fuel"
                                                aria-label="fuel" aria-describedby="basic-addon2" value="">
                                            <span class="input-group-text" id="basic-addon2">Bar</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <input type="text" class="form-control" name="remarks" id="remarks"
                                            placeholder="Remarks">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Image Front</label><br>
                                            <input type="file" class="form-control" id="img_front" name="img_front"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Image Left</label><br>
                                            <input type="file" class="form-control" id="img_left" name="img_left">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Image Right</label><br>
                                            <input type="file" class="form-control" id="img_right" name="img_right">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Image Back</label><br>
                                            <input type="file" class="form-control" id="img_back" name="img_back">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Additional Image 1</label><br>
                                            <input type="file" class="form-control" id="img_add1" name="img_add1">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Additional Image 2</label><br>
                                            <input type="file" class="form-control" id="img_add2" name="img_add2">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Fuel</label><br>
                                            <input type="file" class="form-control" id="img_fuel" name="img_fuel">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>

                            {{-- <input type="file" class="form-control" name="image[]" multiple /> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script></script>
@endsection

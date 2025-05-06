@extends('layouts.layout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
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
                @if ($preinspection)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pickup Form</h5>
                            <div class="row">
                                <div class="col">
                                    <div class="col-md-12">
                                        <label for="text" class="form-label">Parts</label>
                                        @php
                                            // Decode the JSON string to an array
                                            $selectedParts = json_decode($preinspection->parts, true);
                                        @endphp

                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" value="Power Outlet"
                                                    {{ in_array('Power Outlet', $selectedParts) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="parts[]">
                                                    Power Outlet
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" value="Infotainment System"
                                                    {{ in_array('Infotainment System', $selectedParts) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="parts[]">
                                                    Infotainment System
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" value="Carpet"
                                                    {{ in_array('Carpet', $selectedParts) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="parts[]">
                                                    Carpet
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" value="Spare Tyre"
                                                    {{ in_array('Spare Tyre', $selectedParts) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="parts[]">
                                                    Spare Tyre
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="parts[]"
                                                    id="parts[]" value="Car Toolkit"
                                                    {{ in_array('Car Toolkit', $selectedParts) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="parts[]">
                                                    Car Toolkit
                                                </label>
                                            </div>
                                        </div>

                                        {{-- <input type="text" class="form-control" name="parts" id="parts"> --}}
                                    </div>
                                    <div class="col-md-12">
                                        <label for="mileage" class="form-label">Mileage</label>
                                        {{-- <input type="number" class="form-control" name="mileage" id="mileage"
                                                value="{{ $preinspection->mileage }}"> --}}
                                        <div class="input-group mb-3">
                                            <input type="number" name="mileage" class="form-control" placeholder="Mileage"
                                                aria-label="Mileage" aria-describedby="basic-addon2"
                                                value="{{ $preinspection->mileage }}" readonly>
                                            <span class="input-group-text" id="basic-addon2">KM</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="fuel" class="form-label">Fuel</label>
                                        <div class="input-group mb-3">
                                            <input type="number" name="fuel" class="form-control" placeholder="Fuel"
                                                aria-label="fuel" aria-describedby="basic-addon2"
                                                value="{{ $preinspection->fuel }}" readonly>
                                            <span class="input-group-text" id="basic-addon2">Bar</span>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <input type="text" class="form-control" name="remarks" id="remarks" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    @php
                                        $gambar = json_decode($preinspection->image);
                                    @endphp
                                    {{-- @dd($gambar) --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Image Front</label><br>
                                            <img src="{{ asset($gambar->front) }}" alt="" width="50%"
                                                data-bs-toggle="modal" data-bs-target="#imageModal" class="enlarge-image">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Image Left</label><br>
                                            <img src="{{ asset($gambar->left) }}" alt="" width="50%"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                class="enlarge-image">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Image Right</label><br>
                                            <img src="{{ asset($gambar->right) }}" alt="" width="50%"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                class="enlarge-image">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="file">Image Back</label><br>
                                            <img src="{{ asset($gambar->back) }}" alt="" width="50%"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                class="enlarge-image">
                                        </div>
                                        @if (isset($gambar->add1))
                                            <div class="col-md-6">
                                                <label class="form-label" for="file">Additional Image 1</label><br>
                                                <img src="{{ asset($gambar->add1) }}" alt="" width="50%"
                                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                                    class="enlarge-image">
                                            </div>
                                        @endif
                                        @if (isset($gambar->add2))
                                            <div class="col-md-6">
                                                <label class="form-label" for="file">Additional Image 2</label><br>
                                                <img src="{{ asset($gambar->add2) }}" alt="" width="50%"
                                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                                    class="enlarge-image">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        @if ($type == 'pre')
                            <h5 class="card-title"> Pickup Form</h5>
                        @else
                            <h5 class="card-title">Return Form</h5>
                        @endif
                        {{-- <form action="{{ route('inspection.store') }}" method="post" enctype="multipart/form-data"> --}}
                        {{-- @csrf --}}
                        <input type="hidden" class="" name="staff_id" id="staff_id"
                            value="{{ $userId }}">
                        <input type="hidden" class="" name="rental_id" id="rental_id"
                            value="{{ $id }}">
                        <div class="row">
                            <div class="col">
                                <div class="col-md-12">
                                    <label for="text" class="form-label">Parts</label>
                                    @php
                                        // Decode the JSON string to an array
                                        $selectedParts = json_decode($inspection->parts, true);
                                    @endphp

                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="parts[]"
                                                id="parts[]" value="Power Outlet"
                                                {{ in_array('Power Outlet', $selectedParts) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="parts[]">
                                                Power Outlet
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="parts[]"
                                                id="parts[]" value="Infotainment System"
                                                {{ in_array('Infotainment System', $selectedParts) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="parts[]">
                                                Infotainment System
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="parts[]"
                                                id="parts[]" value="Carpet"
                                                {{ in_array('Carpet', $selectedParts) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="parts[]">
                                                Carpet
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="parts[]"
                                                id="parts[]" value="Spare Tyre"
                                                {{ in_array('Spare Tyre', $selectedParts) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="parts[]">
                                                Spare Tyre
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="parts[]"
                                                id="parts[]" value="Car Toolkit"
                                                {{ in_array('Car Toolkit', $selectedParts) ? 'checked' : '' }} disabled>
                                            <label class="form-check-label" for="parts[]">
                                                Car Toolkit
                                            </label>
                                        </div>
                                    </div>

                                    {{-- <input type="text" class="form-control" name="parts" id="parts"> --}}
                                </div>
                                <div class="col-md-12">
                                    <label for="mileage" class="form-label">Mileage</label>
                                    {{-- <input type="number" class="form-control" name="mileage" id="mileage"
                                            value="{{ $inspection->mileage }}"> --}}
                                    <div class="input-group mb-3">
                                        <input type="number" name="mileage" class="form-control" placeholder="Mileage"
                                            aria-label="Mileage" aria-describedby="basic-addon2"
                                            value="{{ $inspection->mileage }}" readonly>
                                        <span class="input-group-text" id="basic-addon2">KM</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="fuel" class="form-label">Fuel</label>
                                    <div class="input-group mb-3">
                                        <input type="number" name="fuel" class="form-control" placeholder="Fuel"
                                            aria-label="fuel" aria-describedby="basic-addon2"
                                            value="{{ $inspection->fuel }}" readonly>
                                        <span class="input-group-text" id="basic-addon2">Bar</span>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control" name="remarks" id="remarks" readonly>
                                </div>
                            </div>
                            <div class="col">
                                @php
                                    $gambar = json_decode($inspection->image);
                                @endphp
                                {{-- @dd($gambar->front --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="{{ asset($gambar->front) }}" alt="" width="50%"
                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                            class="enlarge-image"><br>
                                        <label class="form-label" for="file">Image Front</label>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset($gambar->left) }}" alt="" width="50%"
                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                            class="enlarge-image"><br>
                                        <label class="form-label" for="file">Image Left</label>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset($gambar->right) }}" alt="" width="50%"
                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                            class="enlarge-image"><br>
                                        <label class="form-label" for="file">Image Right</label>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset($gambar->back) }}" alt="" width="50%"
                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                            class="enlarge-image"><br>
                                        <label class="form-label" for="file">Image Back</label>
                                    </div>

                                    @if (isset($gambar->add1))
                                        <div class="col-md-6">
                                            <img src="{{ asset($gambar->add1) }}" alt="" width="50%"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                class="enlarge-image"><br>
                                            <label class="form-label" for="file">Additional Image 1</label>
                                        </div>
                                    @endif
                                    @if (isset($gambar->add2))
                                        <div class="col-md-6">
                                            <img src="{{ asset($gambar->add2) }}" alt="" width="50%"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                class="enlarge-image"><br>
                                            <label class="form-label" for="file">Additional Image 2</label>
                                        </div>
                                    @endif
                                    @if (isset($gambar->fuel))
                                        <div class="col-md-6">
                                            <img src="{{ asset($gambar->fuel) }}" alt="" width="50%"
                                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                                class="enlarge-image"><br>
                                            <label class="form-label" for="file">Fuel</label>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>


                        <div class="pt-2">
                            <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                            {{-- <a href="{{ route('deposit.show', ['id' => $depositId]) }}" target="_blank"
                                class="btn btn-secondary">View
                                Deposit</a> --}}
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Deposit Details</h5>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
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
                        <form action="{{ route('deposit.update', $depositId) }}" method="POST">
                            @csrf
                            <input type="hidden" name="updated_by" value="{{ $userId }}">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>Amount:</strong>
                                        <span>{{ $depo->amount }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>Date:</strong>
                                        <span>{{ $depo->date }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <strong>Status:</strong>
                                        <span class="badge bg-{{ $depo->status === 'Paid' ? 'success' : 'danger' }}">
                                            {{ $depo->status }}
                                        </span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Fuel:</strong>
                                        <input type="number" name="fuel" id="fuel" class="form-control mt-2"
                                            value="{{ $depo->fuel ?? 0 }}">
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Late Return:</strong>
                                        <input type="number" name="late" id="late" class="form-control mt-2"
                                            value="{{ $depo->late ?? 0 }}">
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Extend Rental:</strong>
                                        <div class="d-flex mt-2">
                                            <input type="number" name="extend" id="extend"
                                                class="form-control me-2" value="{{ $depo->extend ?? 0 }}">
                                            <select name="extend_status" id="extend_status" class="form-select">
                                                <option value="Paid"
                                                    {{ $depo->extend_status == 'Paid' ? 'selected' : '' }}>Paid
                                                </option>
                                                <option value="Unpaid"
                                                    {{ $depo->extend_status == 'Unpaid' ? 'selected' : '' }}>Unpaid
                                                </option>
                                            </select>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Remarks:</strong>
                                        <input type="text" name="remarks" id="remarks" class="form-control mt-2"
                                            value="{{ $depo->remarks }}">
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Return Date:</strong>
                                        <input type="date" name="return_date" class="form-control mt-2"
                                            value="{{ $depo->return_date }}">
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Return Amount:</strong>
                                        <input type="number" name="return_amount" id="return_amount"
                                            class="form-control mt-2" value="{{ $depo->return_amount }}" readonly>
                                    </li>
                                </ul>
                                @if (isset($depo->proof))
                                    {{-- @dd($rental->deposit->proof) --}}
                                    <div class="col-4 d-flex align-items-end mt-2">
                                        <a class="btn btn-primary" href="{{ asset($depo->proof) }}" target="_blank">View
                                            Receipt</a>
                                    </div>
                                @else
                                    {{-- Add Proof Logic --}}
                                @endif
                                <div class="text-center pt-2">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" alt="" id="modalImage" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.enlarge-image');
            const modalImage = document.getElementById('modalImage');

            images.forEach(image => {
                image.addEventListener('click', function() {
                    modalImage.src = this.src;
                    modalImage.alt = this.alt;
                });
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure all elements are loaded before running the script
            const fuelElement = document.getElementById('fuel');
            const lateElement = document.getElementById('late');
            const extendElement = document.getElementById('extend');
            const extendStatusElement = document.getElementById('extend_status');
            const returnAmountElement = document.getElementById('return_amount');

            if (!fuelElement || !lateElement || !extendElement || !extendStatusElement || !returnAmountElement) {
                console.error('One or more required elements not found');
                return;
            }

            function calculateReturnAmount() {
                // Use parseFloat to ensure we're working with numbers
                const amount = parseFloat('{{ $depo->amount }}');
                const fuel = parseFloat(fuelElement.value) || 0;
                const late = parseFloat(lateElement.value) || 0;
                const extend = parseFloat(extendElement.value) || 0;
                const extendStatus = extendStatusElement.value;

                let returnAmount = amount - fuel - late;

                if (extendStatus === 'Unpaid') {
                    returnAmount -= extend;
                }

                // Use toFixed(2) to round to 2 decimal places, common for currency
                returnAmountElement.value = returnAmount;

                console.log('Return Amount:', returnAmount);
            }

            // Calculate initially
            calculateReturnAmount();

            // Recalculate when any input changes
            [fuelElement, lateElement, extendElement, extendStatusElement].forEach(element => {
                element.addEventListener('input', calculateReturnAmount);
            });
        });
    </script>
@endsection

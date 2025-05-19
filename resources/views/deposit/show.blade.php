@extends('layouts.layout')
@section('content')
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
                $role = session('role');
            @endphp
            <form action="{{ route('deposit.update', $depo->id) }}" method="POST">
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
                                <input type="number" name="extend" id="extend" class="form-control me-2"
                                    value="{{ $depo->extend ?? 0 }}">
                                <select name="extend_status" id="extend_status" class="form-select">
                                    <option value="Paid" {{ $depo->extend_status == 'Paid' ? 'selected' : '' }}>Paid
                                    </option>
                                    <option value="Unpaid" {{ $depo->extend_status == 'Unpaid' ? 'selected' : '' }}>Unpaid
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
                        @if ($role == 'Admin' || $role == 'Management')
                            <li class="list-group-item">
                                <strong>Return Remark:</strong>
                                <input type="text" name="return_remark" id="return_remark" class="form-control mt-2"
                                    value="{{ $depo->return_remark }}">
                            </li>
                        @endif
                        <li class="list-group-item">
                            <strong>Return Amount:</strong>
                            <input type="number" name="return_amount" id="return_amount" class="form-control mt-2"
                                value="{{ $depo->return_amount }}" readonly>
                        </li>
                    </ul>
                    @if (isset($depo->proof))
                        {{-- @dd($rental->deposit->proof) --}}
                        <div class="col-4 d-flex align-items-end mt-2">
                            <a class="btn btn-primary" href="{{ asset($depo->proof) }}" target="_blank">View Receipt</a>
                        </div>
                    @else
                        {{-- Add Proof Logic --}}
                    @endif
                    <div class="text-center pt-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('deposit.index') }}" class="btn btn-warning">Back</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('script')
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

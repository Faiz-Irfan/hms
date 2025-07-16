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
            <form action="{{ route('deposit.update', $depo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="updated_by" value="{{ $userId }}">
                <div class="row">
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
                @if ($role == 'Admin' || $role == 'Management')
                <div class="col-md-6">
                    <h2>Admin</h2>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Return Remark:</strong>
                            <input type="text" name="return_remark" id="return_remark" class="form-control mt-2"
                                value="{{ $depo->return_remark }}">
                        </li>
                        <li class="list-group-item">
                            <strong>Return Date:</strong>
                            <input type="date" name="return_date" class="form-control mt-2"
                                value="{{ $depo->return_date }}">
                        </li>
                        <li class="list-group-item">
                            <strong>Return Status:</strong>
                            <select name="return_status" id="return_status" class="form-select mt-2">
                                <option value="approve" {{ $depo->return_status == 'approve' ? 'selected' : '' }}>Approve</option>
                                <option value="decline" {{ $depo->return_status == 'decline' ? 'selected' : '' }}>Decline</option>
                                <option value="pending" {{ $depo->return_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </li>
                        <li class="list-group-item">
                            <label for="attachment" class="form-label">Return Proof Attachment</label>
                            @if ($depo->return_proof)
                                @php $files = json_decode($depo->return_proof, true); @endphp
                                <div class="mb-2">
                                    <strong>Current Attachment(s):</strong>
                                    <ul>
                                        @if (is_array($files))
                                            @foreach ($files as $file)
                                                <li>
                                                    <img src="{{ asset($file) }}" alt="" style="max-width: 150px; max-height: 150px; object-fit: contain; display: block;" data-bs-toggle="modal" data-bs-target="#imageModal" class="enlarge-image">
                                                    <a href="{{ asset($file) }}" target="_blank">{{ basename($file) }}</a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li>
                                                <img src="{{ asset($depo->return_proof) }}" alt="" style="max-width: 150px; max-height: 150px; object-fit: contain; display: block;" data-bs-toggle="modal" data-bs-target="#imageModal" class="enlarge-image">
                                                <a href="{{ asset($depo->return_proof) }}" target="_blank">{{ basename($depo->return_proof) }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="mb-2">
                                    <input type="file" class="my-pond" name="filepond[]" multiple />
                                    <small class="text-muted">Upload new file(s) to replace the current attachment(s).</small>
                                </div>
                            @else
                                <input type="file" class="my-pond" name="filepond[]" multiple />
                            @endif
                        </li>
                    </ul>
                </div>
                @endif
                </div>
            </form>

        </div>
    </div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
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
    <script>
        // Register FilePond plugins
        $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
        // Initialize FilePond
        $('.my-pond').filepond({
            allowMultiple: true,
            storeAsFile: true,
        });
        // Listen for addfile event
        $('.my-pond').on('FilePond:addfile', function(e) {
            console.log('file added event', e);
        });

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

@extends('layouts.layout')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Claim Form</h5>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Vertical Form -->
                    <form class="row g-3" action="{{ route('claim.update', $claim->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <label for="category" class="form-label">Claim Type</label>
                            <input type="text" class="form-control" id="category" name="category"
                                value="{{ $claim->category }}" readonly>
                        </div>
                        <div class="col-12">
                            <label for="details" class="form-label">Claim Detail</label>
                            <input type="text" class="form-control" name="details" id="details"
                                value="{{ $claim->details }}">
                        </div>
                        @if (
                            $claim->category == 'Members Rental' ||
                                $claim->category == 'Depo for morning staff' ||
                                $claim->category == 'Sales Commission')
                            <div class="col-md-6">
                                <label for="rental_id" class="form-label">Rental ID</label>
                                <input type="text" class="form-control" name="rental_id" id="rental_id"
                                    value="{{ $claim->rental_id }}">
                            </div>
                        @endif
                        <div class="col-12">
                            <label for="plate_number" class="form-label">Plate</label>
                            <select class="form-control" name="plate_number" id="plate_number">
                                @foreach ($fleet as $plate)
                                    <option value="{{ $plate->license_plate }}"
                                        {{ $claim->plate_number == $plate->license_plate ? 'selected' : '' }}>
                                        {{ $plate->license_plate }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" name="date" id="date"
                                value="{{ $claim->date }}">
                        </div>
                        <div class="col-12">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" name="amount" id="amount"
                                value="{{ $claim->amount }}">
                        </div>
                        <div class="col-12">
                            <label for="attachment" class="form-label">Attachment (Upload to replace, leave blank to keep
                                existing)</label>
                            <input type="file" class="form-control" name="filepond[]" multiple />
                            @if ($claim->receipt)
                                @php $files = json_decode($claim->receipt, true); @endphp
                                <div class="mt-2">
                                    <strong>Current Attachments:</strong>
                                    <ul>
                                        @if (is_array($files))
                                            @foreach ($files as $file)
                                                <li><a href="{{ asset($file) }}"
                                                        target="_blank">{{ basename($file) }}</a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li><a href="{{ asset($claim->receipt) }}"
                                                    target="_blank">{{ basename($claim->receipt) }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Update Claim</button>
                            <button class="btn btn-sm" onclick="window.history.back()">Go Back</button>
                        </div>
                    </form><!-- Vertical Form -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function toggleRentalId() {
            const selected = $('#category').val();
            const showCategories = [
                'Members Rental',
                'Depo for morning staff',
                'Sales Commission'
            ];
            if (showCategories.includes(selected)) {
                $('#rental_id').closest('.col-md-6').show();
            } else {
                $('#rental_id').closest('.col-md-6').hide();
                $('#rental_id').val('');
            }
        }

        // Initial check on page load
        toggleRentalId();

        // On category change
        $('#category').on('change', toggleRentalId);
    </script>
@endsection

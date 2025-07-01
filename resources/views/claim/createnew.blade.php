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
                <h5 class="card-title">Claim</h5>
                @php
                    $userId = session('user_id');
                @endphp
                <form action="{{ route('claim.store', ['id' => 'members']) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="" id="staff_id" name="staff_id" value="{{ $userId }}">
                    <div class="col-md-6">
                        <label for="category" class="form-label">Claim Type</label>
                        <select class="form-control" name="category" id="category">
                            @foreach ($claimType as $item)
                                <option value="{{ $item->description }}">{{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="details" class="form-label">Claim Details</label>
                        <input type="text" class="form-control" name="details" id="details">
                    </div>
                    <div class="col-md-6">
                        <label for="rental_id" class="form-label">Rental ID</label>
                        <input type="number" class="form-control" name="rental_id" id="rental_id">
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
                        <input type="date" class="form-control date" name="date" id="date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="amount" class="form-label">Amount (RM)</label>
                        <input type="text" class="form-control" name="amount" id="amount" placeholder="10.00">
                    </div>
                    <div class="col-md-6">
                        <label for="attachment" class="form-label">Attachment</label>
                        <input type="file" class="my-pond" name="filepond[]" multiple />

                    </div>
                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary">Submit Claim</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
    </div>
@endsection
@section('script')
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
        $(function() {
            $('.date').datepicker({
                dateFormat: 'yy-mm-dd'
            }).val();
            $('#date-extra').datepicker({
                dateFormat: 'yy-mm-dd'
            }).val();
            $('#date-claim').datepicker({
                dateFormat: 'yy-mm-dd'
            }).val();

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
        });

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

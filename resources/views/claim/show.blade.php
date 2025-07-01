@extends('layouts.layout')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Claim Details</h5>
            {{-- @dd($claim) --}}
            {{-- <a class="btn btn-primary" href="{{ route('claim.edit', ['id' => $claim->id]) }}">Edit</a> --}}
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
            {{-- @if ($category == 'members')
                @include('components.claim.member')
            @elseif($category == 'extra')
                @include('components.claim.extra')
            @elseif($category == 'depo')
                @include('components.claim.depo')
            @elseif($category == 'claims')
                @include('components.claim.claims')
            @endif --}}
            <table class="table table-bordered">
                <tr>
                    <th>Category</th>
                    <td>{{ $claim->category ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Details</th>
                    <td>{{ $claim->details ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Staff</th>
                    <td>{{ $claim->staff->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $claim->date ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Plate Number</th>
                    <td>{{ $claim->plate_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td>{{ $claim->amount ? 'RM ' . number_format($claim->amount, 2) : '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($claim->status) ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Rental ID</th>
                    <td>{{ $claim->rental_id ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Attachment(s)</th>
                    <td>
                        @if ($claim->receipt)
                            @php $files = json_decode($claim->receipt, true); @endphp
                            @if (is_array($files))
                                <ul>
                                    @foreach ($files as $file)
                                        <li>
                                            <a href="{{ asset($file) }}" target="_blank">
                                                {{ basename($file) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <a href="{{ asset($claim->receipt) }}" target="_blank">{{ basename($claim->receipt) }}</a>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </table>
            <div class="pt-2">
                <a href="{{ url()->previous() }}" class="btn btn-primary">Go Back</a>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endpush

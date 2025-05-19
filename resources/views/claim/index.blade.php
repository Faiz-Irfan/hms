@extends('layouts.layout')
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Claims</h5>
                    <a href="{{ route('claim.create') }}" class="btn btn-primary">New Claim</a>
                    @php
                        $user = Auth::user();
                        $role = $user ? $user->getRoleNames()->first() : 'No role assigned';
                    @endphp
                    @if ($role == 'Admin' || $role == 'Management')
                        <a href="{{ route('claim.indexAdmin') }}" class="btn btn-primary">Manage Claim</a>
                    @endif

                    <table id="tableData" class="datatable table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Detail</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($claims as $item)
                                <tr>
                                    <td>{{ $item->claim_id }}</td>
                                    <td>
                                        @if ($item->category == 'members')
                                            <span class="badge bg-success">Members Rental</span>
                                        @elseif($item->category == 'extra')
                                            <span class="badge bg-secondary">Extra Job</span>
                                        @elseif($item->category == 'depo')
                                            <span class="badge bg-info">Morning Depo</span>
                                        @elseif($item->category == 'claims')
                                            <span class="badge bg-dark">Staff Claims</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->date }} <br> {{ $item->details }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>
                                        @if ($item->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($item->status == 'declined')
                                            <span class="badge bg-danger">Declined</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->payment_date }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary " type="button" id="dropdownMenuButton"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bi bi-grip-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                {{-- <a class="dropdown-item" href="claim/view/{{ $item->id }}">View</a> --}}
                                                {{-- <a class="dropdown-item"
                                                    href="{{ route('claim.show', ['id' => $item->claim_id, 'category' => $item->category]) }}">View</a> --}}
                                                <a class="dropdown-item"
                                                    href="{{ route('claim.edit', ['id' => $item->claim_id]) }}">Edit</a>
                                                <a class="dropdown-item"
                                                    href="{{ route('claim.destroy', $item->claim_id) }}">Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
@endsection

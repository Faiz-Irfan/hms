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

                    <table id="tableData" class="datatable table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // dd($claims)
                            @endphp
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
                                        <div class="row">
                                            <div class="col">
                                                <a href="{{ route('claim.edit', $item->claim_id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                            </div>
                                            <div class="col">
                                                <a href="{{ route('claim.show', ['id' => $item->claim_id, 'category' => $item->category]) }}"
                                                    class="btn btn-primary btn-sm">Show</a>
                                            </div>
                                            <div class="col">
                                                <form action="{{ route('claim.destroy', $item->claim_id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
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

@push('scripts')
    {{-- <script>
    $(document).ready(function() {
        $('#tableData').DataTable();
    });
</script> --}}
@endpush
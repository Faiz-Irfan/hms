@extends('layouts.layout')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 90px;
        height: 34px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ca2222;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2ab934;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(55px);
        -ms-transform: translateX(55px);
        transform: translateX(55px);
    }

    /*------ ADDED CSS ---------*/
    .on {
        display: none;
    }

    .on,
    .off {
        color: white;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        font-size: 10px;
        font-family: Verdana, sans-serif;
        user-select: none;
    }

    input:checked+.slider .on {
        display: block;
    }

    input:checked+.slider .off {
        display: none;
    }

    /*--------- END --------*/

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
@section('content')
    <section class="section">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Staff Claims</h5>
                        {{-- <a href="{{ route('claim.create') }}" class="btn btn-primary">New Claim</a> --}}

                        <div class="table-responsive">
                            <table id="tableData" class="datatable table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        {{-- <th>ID</th> --}}
                                        <th>Staff</th>
                                        <th>Category</th>
                                        <th>Details</th>
                                        <th>Plate Number</th>
                                        <th>Claim Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($claims as $item)
                                        {{-- @dd($item) --}}
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            {{-- <td>{{ $item->id }}</td> --}}
                                            <td>{{ $item->user_name }}</td>
                                            <td>
                                                {{ $item->category }}
                                            </td>
                                            <td>{{ $item->details }}</td>
                                            <td>{{ $item->plate_number }}</td>
                                            <td>{{ $item->date }}</td>
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
                                            <td>
                                                <div class="row">
                                                    <div class="col">
                                                        <form action="{{ route('claims.updateStatus', $item->claim_id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="btn-group">
                                                                <button type="submit" name="status" value="approved"
                                                                    class="btn btn-sm btn-success"
                                                                    {{ $item->status === 'approved' ? 'disabled' : '' }}>
                                                                    Approve
                                                                </button>
                                                                <button type="submit" name="status" value="declined"
                                                                    class="btn btn-sm btn-danger"
                                                                    {{ $item->status === 'declined' ? 'disabled' : '' }}>
                                                                    Decline
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    {{-- <div class="col">
                                                        <a href="{{ routinye('claim.edit', $item->claim_id) }}"
                                                            class="btn btn-primary btn-sm">Edit</a>
                                                    </div> --}}
                                                    <div class="col">
                                                        <div class="btn-group">
                                                            <a type="button"
                                                                href="{{ route('claim.show', ['id' => $item->claim_id, 'category' => $item->category]) }}"
                                                                class="btn btn-primary"><i
                                                                    class="bi bi-pencil-square"></i></a>
                                                            <a type="button" class="btn btn-primary delete-btn"
                                                                data-url="{{ route('claim.destroy', $item->claim_id) }}">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        </div>
                                                        {{-- <a href="{{ route('claim.show', ['id' => $item->claim_id, 'category' => $item->category]) }}"
                                                            class="btn btn-primary btn-sm">View</a> --}}
                                                    </div>
                                                    {{-- <div class="col">
                                                        <form action="{{ route('claim.destroy', $item->claim_id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </div> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let url = this.getAttribute('data-url');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url; // Redirect to delete route
                    }
                });
            });
        });
    </script>
    <script>
        // $('#example').DataTable();

        const togBtns = document.querySelectorAll('.tog-btn');
        const claimStatusForms = document.querySelectorAll('.claim-status-form');

        togBtns.forEach((togBtn, index) => {
            togBtn.addEventListener('change', function() {
                claimStatusForms[index].submit();
            });
        });
    </script>
@endsection

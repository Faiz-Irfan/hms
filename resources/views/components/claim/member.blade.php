{{-- @dd($claim) --}}
<p>Members Rental</p>
<div class="col-md-6">
    <ul class="list-group">
        <li class="list-group-item">Customer Name : {{ $customer->name }}</li>
        <li class="list-group-item">Email : {{ $customer->email }}</li>
        <li class="list-group-item">Phone : {{ $customer->phone }}</li>
        <li class="list-group-item">Address : {{ $customer->address }}</li>
        <li class="list-group-item">Claim Details : {{ $claim->details }}</li>
        <li class="list-group-item">Plate Number : {{ $claim->fleet->plate_number ?? 'N/A' }}</li>
        <li class="list-group-item">Date : {{ $claim->date }}</li>
        <li class="list-group-item">Rental Amount : RM {{ $claim->rental_amount }}</li>
        @isset($claim->receipt)
            <li class="list-group-item d-flex flex-row">Receipt :
                <div class="ps-2">
                    <a class="btn btn-primary" href="{{ asset($claim->receipt) }}" target="_blank">View</a>
                </div>
            </li>
        @endisset
        <li class="list-group-item">
            @if ($claim->status == 'approved')
                <span class="badge bg-success">Approved</span>
            @elseif($claim->status == 'declined')
                <span class="badge bg-danger">Declined</span>
            @else
                <span class="badge bg-warning">Pending</span>
            @endif
        </li>
    </ul>

</div>

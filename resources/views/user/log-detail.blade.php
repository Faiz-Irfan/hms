@extends('layouts.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Log Detail</h5>
                <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $log->id }}</td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>{{ $log->causer ? $log->causer->name : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Action</th>
                        <td>{{ $log->description }}</td>
                    </tr>
                    <tr>
                        <th>Timestamp</th>
                        <td>{{ $log->created_at->format('j M Y, H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Subject Type</th>
                        <td>{{ $log->subject_type ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Subject ID</th>
                        <td>{{ $log->subject_id ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Properties (Changes)</th>
                        <td>
                            <pre class="mb-0">{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </td>
                    </tr>
                </table>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Add any custom JavaScript here if needed
        });
    </script>
@endsection

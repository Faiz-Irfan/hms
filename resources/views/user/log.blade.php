@extends('layouts.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User Activity Log</h5>
                    <div class="table-responsive">
                        <table id="tableData" class="datatable table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User ID</th>
                                    <th>Action</th>
                                    <th>Timestamp</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>{{ $log->causer ? $log->causer->name : 'N/A' }}</td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->created_at->format('j M Y, H:i:s') }}</td>
                                        <td>
                                            <a href="{{ route('log.detail', $log->id) }}" class="btn btn-sm btn-info">View Details</a>
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
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Add any custom JavaScript here if needed
        });
    </script>
@endsection

@extends('layouts.layout')
@section('content')
    <div class="container">
        <h1>User Activity Log</h1>
        <table id="tableData" class="datatable table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->causer ? $log->causer->name : 'N/A' }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- {{ $logs->links() }} --}}
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Add any custom JavaScript here if needed
        });
    </script>
@endsection

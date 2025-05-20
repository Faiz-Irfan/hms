@extends('layouts.layout')

@section('content')
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">
            @if(auth()->user()->hasRole('Admin'))
                Task Management
            @else
                My Tasks
            @endif
        </h2>

        @if(auth()->user()->hasRole('Admin'))
            <!-- Add Task Form (Admin Only) -->
            <form action="{{ route('todos.store') }}" method="POST" class="mb-4">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6">
                        <input type="text" name="task" placeholder="New Task" required class="form-control">
                    </div>
                    <div class="col-md-4">
                        <select name="staff_id" required class="form-control">
                            <option value="">Assign to Staff</option>
                            @foreach($staff as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Assign Task</button>
                    </div>
                </div>
            </form>
        @endif

        <!-- Tasks Table -->
        <div class="card">
            <div class="card-body">
                <table id="todoTable" class="datatable table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Task</th>
                            @if(auth()->user()->hasRole('Admin'))
                                <th>Assigned To</th>
                                <th>Created By</th>
                            @endif
                            <th>Status</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($todos as $todo)
                            <tr>
                                <td>{{ $todo->id }}</td>
                                <td>{{ $todo->task }}</td>
                                @if(auth()->user()->hasRole('Admin'))
                                    <td>{{ $todo->staff->name }}</td>
                                    <td>{{ $todo->creator->name }}</td>
                                @endif
                                <td>
                                    @if ($todo->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $todo->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if(auth()->user()->hasRole('Admin'))
                                        <div class="dropdown">
                                            <button class="btn btn-primary" type="button" id="dropdownMenuButton{{ $todo->id }}"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $todo->id }}">
                                                @if ($todo->status == 'pending')
                                                    <form action="{{ route('todos.update', $todo->id) }}" method="POST" class="dropdown-item">
                                                        @csrf 
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-link p-0 text-success">
                                                            Mark Complete
                                                        </button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="dropdown-item">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link p-0 text-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        @if ($todo->status == 'pending')
                                            <form action="{{ route('todos.update', $todo->id) }}" method="POST" class="d-inline">
                                                @csrf 
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    Mark Complete
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#todoTable').DataTable({
                "order": [[0, "desc"]]
            });
        });
    </script>
    @endpush
@endsection

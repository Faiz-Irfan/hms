<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller {
  

    // Show all tasks
    public function index() {
        $user = Auth::user();
        
        // If user is admin, show all tasks
        if ($user->hasRole('Admin')) {
            $todos = Todo::with(['staff', 'creator'])->get();
            $staff = User::role('Staff')->get();
            return view('todos.index', compact('todos', 'staff'));
        } else {
            // If user is staff, only show their tasks
            $todos = Todo::with('creator')->where('staff_id', $user->id)->get();
            $staff = collect(); // Empty collection for staff view
            return view('todos.index', compact('todos', 'staff'));
        }
    }

    // Store a new task (Admin only)
    public function store(Request $request) {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'task' => 'required|string|max:255',
            'staff_id' => 'required|exists:users,id'
        ]);

        Todo::create([
            'task' => $request->task,
            'staff_id' => $request->staff_id,
            'created_by' => auth()->id(),
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Task assigned successfully');
    }

    // Update task status
    public function update(Request $request, Todo $todo) {
        $user = Auth::user();
        
        // Only allow staff to update their own tasks or admin to update any task
        if (!$user->hasRole('Admin') && $todo->staff_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $todo->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Task marked as completed');
    }

    // Delete a task (Admin only)
    public function destroy(Todo $todo) {
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized action.');
        }
        
        $todo->delete();
        return redirect()->back()->with('success', 'Task deleted');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function createRole(){
        // Create Admin role
        $adminRole = Role::create(['name' => 'Admin']);

        // Create Manager role
        $managerRole = Role::create(['name' => 'Manager']);

        // Create Top role
        $topRole = Role::create(['name' => 'Top']);

        // Create Staff role
        $staffRole = Role::create(['name' => 'Staff']);
    }

    public function createPermission(){
        $permission = Permission::create(['name' => 'edit articles']);
    }

    public function profile(){
        return view('user.profile');
    }

    public function index(){
        $users = User::with('roles')->get();
        
        return view('user.index')->with('users', $users);
    }

    public function create(){
        $roles = DB::table('roles')->get();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request){

        // $request->validate([
        // 'details' => 'required|max:255',
        // 'amount' => 'required',
        // 'plate_number' => 'required',
        // 'date' => 'required',
        // 'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        // ]);

        $data = $request->all();

        // $user = new User();
        // $user->name = $data['name'];
        // $user->email = $data['email'];
        // $user->password = Hash::make($data['password']);
        // $user->save();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
         ]);
         

        // activity()->log('Look mum, I logged something');

        $role = Role::findByName($data['role']);
        $user->assignRole($role->name);

        return redirect()->route('user.index')
        ->with('success', 'User created successfully.');
    }

    public function show($id){
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all(); // Get all available roles
        return view('user.show', compact('user', 'roles'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|exists:roles,id'
        ]);

        // dd($request->all());

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update role
        $role = Role::findById($request->role);
        $user->syncRoles($role->name);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index')
        ->with('success', 'User deleted successfully');
    }

    public function log(){
        $logs = \Spatie\Activitylog\Models\Activity::all();
        return view('user.log', compact('logs'));
    }

    public function logDelete($id){
        $log = \Spatie\Activitylog\Models\Activity::find($id);
        $log->delete();
        return redirect()->route('user.log')
        ->with('success', 'Log deleted successfully');
    }
    
}

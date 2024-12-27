<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.master.user.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        $user->assignRole($request->role);

        if ($request->role === 'teacher') {
            Teacher::create([
                'name' => $request->full_name,
                'subject' => 'General',
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('admin.master-data.user.index')->with('success', 'User created successfully!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'role' => 'required|string|exists:roles,name',
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
        ]);

        $user->syncRoles([$request->role]);

        if ($request->role === 'teacher') {
            $teacher = Teacher::firstOrNew(['user_id' => $user->id]);
            $teacher->name = $request->full_name;
            $teacher->subject = $teacher->subject ?? 'General'; 
            $teacher->save();
        } else {
            Teacher::where('user_id', $user->id)->delete();
        }

        return redirect()->route('admin.master-data.user.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        Teacher::where('user_id', $user->id)->delete();
        $user->delete();

        return response()->json(['success' => 'User deleted successfully!']);
    }

    public function toggleStatus(Request $request, User $user)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user->update([
            'is_active' => $request->is_active,
        ]);

        if ($user->roles->pluck('name')->contains('teacher')) {
            Teacher::where('user_id', $user->id)->update(['is_active' => $request->is_active]);
        }

        return response()->json(['success' => true, 'message' => 'User status updated successfully!']);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return $this->users();
    }

    public function users()
    {
        $users = User::paginate(20);
        
        $roleStats = [
            'inspector' => User::where('role', 'inspector')->count(),
            'analyst' => User::where('role', 'analyst')->count(),
            'broker' => User::where('role', 'broker')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];

        return view('admin.users', compact('users', 'roleStats'));
    }

    public function createUser()
    {
        return view('admin.create-user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users|max:255',
            'full_name' => 'required|string|max:255',
            'role' => 'required|in:inspector,analyst,broker,admin',
        ]);

        User::create([
            'api_id' => 'user-' . uniqid(),
            'username' => $request->username,
            'full_name' => $request->full_name,
            'password' => Hash::make($request->username),
            'role' => $request->role,
            'active' => true,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->has('toggle_active')) {
            $user->update(['active' => !$user->active]);
            return redirect()->route('admin.users')->with('success', 'User status updated');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'full_name' => 'required|string|max:255',
            'role' => 'required|in:inspector,analyst,broker,admin',
        ]);

        $data = $request->only(['username', 'full_name', 'role']);
        if ($request->password) {
            $request->validate(['password' => 'string|min:6|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }
}

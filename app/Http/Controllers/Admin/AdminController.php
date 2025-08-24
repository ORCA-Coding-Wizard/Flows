<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'Admin')->paginate(10);
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        $admins = User::where('role', 'Admin')->paginate(10);
        return view('admin.index', compact('admins'))->with('openModal', 'create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'Admin',
        ]);

        return redirect()->route('admin.kelola-admin.index')
                         ->with('success', 'Admin berhasil ditambahkan');
    }

    public function destroy(User $admin)
    {
        $admin->delete();

        return redirect()->route('admin.kelola-admin.index')
                         ->with('success', 'Admin berhasil dihapus');
    }
}

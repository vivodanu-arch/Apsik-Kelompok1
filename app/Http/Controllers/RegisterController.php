<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        if (!auth()->user()->is_super_admin) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:6'],
            'role' => ['required']
        ]);

        \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'is_super_admin' => 0
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }
    public function create()
    {
        if (!auth()->user()->is_super_admin) {
            abort(403);
        }

        return view('auth.register');
    }
}
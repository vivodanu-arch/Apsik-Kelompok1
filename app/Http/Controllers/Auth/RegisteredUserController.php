<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // 🔒 HANYA SUPER ADMIN
        if (!auth()->check() || auth()->user()->is_super_admin != 1) {
            abort(403);
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 🔒 HANYA SUPER ADMIN
        if (!auth()->check() || auth()->user()->is_super_admin != 1) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],
            'role' => [
                'required',
                'string',
                'in:petugas,dokter,kepalarm'
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_super_admin' => 0, // 🔥 default user biasa
        ]);

        event(new Registered($user));

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }
}
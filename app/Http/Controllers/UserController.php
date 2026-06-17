<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // 📋 DATA
        $users = $query->latest()->get();

        // Hitung jumlah kunjungan untuk setiap user berstatus dokter (untuk peringatan hapus)
        $jumlahKunjunganDokter = [];
        foreach ($users->where('role', 'dokter') as $u) {
            if ($u->dokter) {
                $jumlahKunjunganDokter[$u->id] = $u->dokter->kunjungans()->count();
            }
        }

        return view('users.index', compact('users', 'jumlahKunjunganDokter'));
    }

    public function destroy(User $user)
    {
        // 🔒 Tidak boleh hapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // 🔒 Tidak boleh hapus super admin lain
        if ($user->is_super_admin) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Akun Super Admin tidak dapat dihapus.');
        }

        $nama = $user->name;
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', "User \"{$nama}\" berhasil dihapus.");
    }
}
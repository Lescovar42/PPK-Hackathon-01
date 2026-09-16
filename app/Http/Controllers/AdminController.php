<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Tampilkan semua akun
    public function index()
    {
        $users = User::all();

        return view('admin.index', compact('users'));
    }

    // Simpan akun baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password'),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.index')->with('success', 'Akun berhasil ditambahkan!');
    }

    // Hapus akun
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'Akun berhasil dihapus!');
    }
}

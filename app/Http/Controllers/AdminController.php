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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.index')->with('success', 'Akun berhasil ditambahkan!');
    }

    // Hapus akun
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.index')->with('success', 'Akun berhasil dihapus!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TodoList; // Sesuaikan dengan nama Model list kamu
use App\Models\Task;     // Model Task
use App\Models\ListMember; // Model Anggota List

class ListController extends Controller
{
    /**
     * Fitur 1: Membuat daftar baru & otomatis menjadi Owner.
     */
    public function store(Request $request)
    {
        // 1. Validasi input sederhana
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 2. [ISOLASI P2] Hardcode user ID sementara. 
        // Nanti P3 akan mengganti ini dengan Auth::id()
        $currentUserId = 1; 

        // Gunakan transaksi agar pembuatan daftar & keanggotaan owner aman
        try {
            $newList = DB::transaction(function () use ($request, $currentUserId) {
                
                // Buat data list baru
                $todolist = TodoList::create([
                    'name' => $request->name,
                ]);

                // Otomatis masukkan pembuat sebagai 'owner' di tabel relasi/keanggotaan
                ListMember::create([
                    'list_id' => $todolist->id,
                    'user_id' => $currentUserId,
                    'role'    => 'owner',
                ]);

                return $todolist;
            });

            return response()->json([
                'message' => 'Daftar berhasil dibuat dan Anda otomatis menjadi pemilik.',
                'data'    => $newList
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat daftar.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fitur 2: Hapus daftar secara Atomic (Cascade Delete).
     * Menghapus list, seluruh tugas di dalamnya, dan keanggotaan sekaligus.
     */
    public function destroy($id)
    {
        // [ISOLASI P2] Hardcode user ID sementara untuk cek kepemilikan
        $currentUserId = 1;

        try {
            // DB::transaction menjamin: jika satu gagal, semua dibatalkan (Rollback)
            DB::transaction(function () use ($id, $currentUserId) {
                
                // Pastikan yang mau hapus benar-benar owner dari list tersebut
                $isOwner = ListMember::where('list_id', $id)
                    ->where('user_id', $currentUserId)
                    ->where('role', 'owner')
                    ->exists();

                if (!$isOwner) {
                    abort(403, 'Akses ditolak. Anda bukan pemilik daftar ini.');
                }

                // 1. Hapus semua tugas (tasks) yang terikat dengan list ini
                Task::where('list_id', $id)->delete();

                // 2. Hapus semua keanggotaan (list_members) di list ini
                ListMember::where('list_id', $id)->delete();

                // 3. Hapus list itu sendiri (todo_lists)
                TodoList::where('id', $id)->delete();
            });

            return response()->json([
                'message' => 'Daftar beserta seluruh tugas dan anggotanya berhasil dihapus.'
            ], 200);

        } catch (\Exception $e) {
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
            // $statusCode = $e->getCode() == 403 ? 403 : 500;
            return response()->json([
                'message' => 'Proses hapus dibatalkan (Rollback).',
                'error'   => $e->getMessage()
            ], $statusCode);
        }
    }
}
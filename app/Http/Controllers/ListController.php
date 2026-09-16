<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project; // Menggunakan model Project
use App\Models\Task;    // Menggunakan model Task

class ListController extends Controller
{
    /**
     * Fitur 1: Membuat proyek/daftar baru & otomatis menjadi Owner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $currentUserId = 1; // Hardcode sementara untuk P3

        try {
            $newProject = DB::transaction(function () use ($request, $currentUserId) {
                
                // Membuat project baru dan otomatis menetapkan user yang login sebagai pemilik
                // Sesuaikan nama kolom (misal: 'user_id' atau 'owner_id') dengan database kalian
                $project = Project::create([
                    'name' => $request->name,
                    'user_id' => $currentUserId, // atau 'owner_id' => $currentUserId
                ]);

                return $project;
            });

            return response()->json([
                'message' => 'Proyek berhasil dibuat dan Anda otomatis menjadi pemilik.',
                'data'    => $newProject
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat proyek.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fitur 2: Hapus proyek secara Atomic (Cascade Delete).
     * Menghapus proyek beserta seluruh tugas di dalamnya sekaligus.
     */
    public function destroy($id)
    {
        $currentUserId = 1; // Hardcode sementara

        try {
            DB::transaction(function () use ($id, $currentUserId) {
                
                // Cari proyek berdasarkan ID dan pastikan yang menghapus adalah pemiliknya
                $project = Project::where('id', $id)->first();

                if (!$project) {
                    abort(404, 'Proyek tidak ditemukan.');
                }

                // Cek otorisasi kepemilikan (sesuaikan kolom foreign key di tabel projects)
                if ($project->user_id != $currentUserId) { // atau $project->owner_id != $currentUserId
                    abort(403, 'Akses ditolak. Anda bukan pemilik proyek ini.');
                }

                // 1. Hapus semua tugas (tasks) yang terikat dengan proyek ini
                // Sesuaikan nama foreign key di tabel tasks (misal: 'project_id')
                Task::where('project_id', $id)->delete();

                // 2. Hapus proyek itu sendiri
                $project->delete();
            });

            return response()->json([
                'message' => 'Proyek beserta seluruh tugasnya berhasil dihapus secara atomik.'
            ], 200);

        } catch (\Exception $e) {
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
            
            return response()->json([
                'message' => 'Proses hapus dibatalkan (Rollback).',
                'error'   => $e->getMessage()
            ], $statusCode);
        }
    }
}
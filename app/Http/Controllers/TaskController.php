<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController
{
    // FR-02: Tambah Tugas Baru
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);

        $project->tasks()->create([
            'name' => $request->name,
            'deadline' => $request->deadline,
            // is_done tidak perlu diisi karena default false di database
        ]);

        return back()->with('success', 'Tugas berhasil ditambahkan!');
    }

    // FR-03: Ubah Status Tugas Selesai
    public function toggleStatus(Task $task)
    {
        // Toggle nilai is_done dari false ke true atau sebaliknya
        $task->update([
            'is_done' => !$task->is_done
        ]);

        return back()->with('success', 'Status tugas diperbarui!');
    }
}

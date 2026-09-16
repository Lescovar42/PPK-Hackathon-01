<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // FR-02: Tambah Tugas Baru
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required_without:title|nullable|string|max:255',
            'title' => 'required_without:name|nullable|string|max:255',
            'deadline' => 'nullable|date',
        ]);

        $taskName = $request->filled('name')
            ? $request->input('name')
            : $request->input('title');

        $project->tasks()->create([
            'name' => $taskName,
            'deadline' => $request->filled('deadline') ? $request->input('deadline') : null,
            // is_done tidak perlu diisi karena default false di database
        ]);

        return redirect()
            ->back(fallback: route('projects.show', $project))
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    // FR-03: Ubah Status Tugas Selesai
    public function toggleStatus(Task $task)
    {
        // Toggle nilai is_done dari false ke true atau sebaliknya
        $task->update([
            'is_done' => ! $task->is_done,
        ]);

        return redirect()
            ->back(fallback: route('projects.show', $task->project_id))
            ->with('success', 'Status tugas diperbarui!');
    }
}

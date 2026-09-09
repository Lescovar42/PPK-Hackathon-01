<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController
{
    // FR-01: Buat Proyek/List Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Project::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Proyek berhasil dibuat!');
    }

    // FR-04: Tampilkan Daftar Tugas (Berdasarkan Proyek)
    public function show(Project $project)
    {
        $project = \App\Models\Project::findOrFail($id);
        
        // Mengambil tugas yang hanya terkait dengan proyek ini
        $tasks = $project->tasks()->orderBy('deadline', 'asc')->get();

        return view('projects.show', compact('project', 'tasks')); 
        // Jika API: return response()->json(['project' => $project, 'tasks' => $tasks]);
    }
}

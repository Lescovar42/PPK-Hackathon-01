<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Tampilkan Daftar Proyek
    public function index()
    {
        $projects = Project::withCount('tasks')->get();

        return view('projects.index', compact('projects'));
    }

    // FR-01: Buat Proyek/List Baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Project::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dibuat!');
    }

    // FR-04: Tampilkan Daftar Tugas (Berdasarkan Proyek)
    public function show(Project $project)
    {
        // Mengambil tugas yang hanya terkait dengan proyek ini
        $tasks = $project->tasks()->orderBy('deadline', 'asc')->get();

        return view('projects.show', compact('project', 'tasks'));
    }
}

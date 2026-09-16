<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectCollaborationController extends Controller
{
    public function show(Project $project)
    {
        $users = User::all();

        $members = $project->users;

        $totalTasks = $project->tasks()->count();

        $completedTasks = $project->tasks()
            ->where('is_done', true)
            ->count();

        $progress = $totalTasks > 0
            ? round(($completedTasks / $totalTasks) * 100, 2)
            : 0;

        return view('projects.collaboration', compact(
            'project',
            'users',
            'members',
            'totalTasks',
            'completedTasks',
            'progress'
        ));
    }

    public function addMember(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $project->users()->syncWithoutDetaching([
            $request->user_id,
        ]);

        return redirect()
            ->route('projects.collaboration', $project)
            ->with('success', 'Anggota berhasil ditambahkan.');
    }
}

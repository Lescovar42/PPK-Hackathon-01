<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProjectCollaborationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Halaman Utama / Landing Page
Route::view('/', 'welcome')->name('home');

// Rute Crew 1: Project & Task
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleStatus'])->name('tasks.toggle');

// Rute Crew 2: Collaboration & Progress
Route::get('/projects/{project}/collaboration', [ProjectCollaborationController::class, 'show'])->name('projects.collaboration');
Route::post('/projects/{project}/members', [ProjectCollaborationController::class, 'addMember'])->name('projects.members.add');

// Rute Crew 3: Admin
Route::redirect('/admin', '/admin/users');
Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.store');
Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');

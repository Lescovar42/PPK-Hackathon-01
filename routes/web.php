<?php
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

// halaman utama
Route::get('/', function () {
    return view('projects.show');
});
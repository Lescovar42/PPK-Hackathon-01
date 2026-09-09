<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Models\User; // Tambahkan ini di atas

Route::get('/', function () {
    $users = User::all();
    return view('welcome', compact('users')); // Kirim variabel $users ke view
});

// Rute Crew 3
Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.store');
Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookRegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

    // 2. Rutas públicas (login, register, etc.) → Breeze las carga desde auth.php
    require __DIR__.'/auth.php';

    // 3. Rutas protegidas por autenticación
    Route::middleware(['auth'])->group(function () {
    
    // Dashboard para estudiantes
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //Dashboard para administrador
        Route::middleware('rol:administrador')->get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');



       // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //otra ruta admin (ejemplo)
    Route::get('/admin', [AdminController::class, 'index'])->middleware('rol:administrador');

    // RUTAS PARA LIBROS

    Route::get('books/create', [BookRegistrationController::class, 'create'])->name('books.create');
    Route::post('books',       [BookRegistrationController::class, 'store'])->name('books.store');


});




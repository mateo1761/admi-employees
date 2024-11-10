<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DeparmentController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Department
    Route::get('departments', [DeparmentController::class, 'index'])->name('deparments.index');
    Route::get('departments/create', [DeparmentController::class, 'create'])->name('deparments.create');
    Route::post('departments', [DeparmentController::class, 'store'])->name('deparments.store');
    Route::get('departments/{deparment}', [DeparmentController::class, 'show'])->name('departments.show');
    Route::get('departments/{deparment}/edit', [DeparmentController::class, 'edit'])->name('departments.edit');
    Route::put('departments/{deparment}', [DeparmentController::class, 'update'])->name('departments.update');
    Route::delete('departments/{deparment}', [DeparmentController::class, 'destroy'])->name('departments.destroy');

    //Employee
    Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('graphic', [EmployeeController::class, 'employeeByDeparment'])->name('graphic');
    Route::get('reports', [EmployeeController::class, 'reports'])->name('reports');
});

require __DIR__.'/auth.php';

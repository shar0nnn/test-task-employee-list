<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('employees.index');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'showLoginComponent'])->name('login-component.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {

    Route::prefix('/employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/get', [EmployeeController::class, 'getEmployees'])->name('employees.get');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::patch('/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        Route::get('/get-names/{name}/{rank?}', [EmployeeController::class, 'getNames'])->name('employees.get-names');
    });

    Route::prefix('/positions')->group(function () {
        Route::get('/', [PositionController::class, 'index'])->name('positions.index');
        Route::get('/get', [PositionController::class, 'getPositions'])->name('positions.get');
        Route::get('/create', [PositionController::class, 'create'])->name('positions.create');
        Route::post('/store', [PositionController::class, 'store'])->name('positions.store ');
        Route::get('/{position}/edit', [PositionController::class, 'edit'])->name('positions.edit');
        Route::patch('/{position}', [PositionController::class, 'update'])->name('positions.update');
        Route::delete('/{position}', [PositionController::class, 'destroy'])->name('positions.destroy');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

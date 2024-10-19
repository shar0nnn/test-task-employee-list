<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'showLoginComponent'])->name('login-component.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {

    Route::prefix('/employees')->group(function () {
        Route::get('/list', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/get', [EmployeeController::class, 'getEmployees'])->name('employees.get');
        Route::get('/create', [EmployeeController::class, 'showCreateEmployeeComponent'])->name('employees.create.show');
        Route::post('/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::get('/get-names/{name}', [EmployeeController::class, 'getNames'])->name('employees.get-names');
    });

    Route::prefix('/positions')->group(function () {
        Route::get('/list', [PositionController::class, 'index'])->name('positions.index');
        Route::get('/get', [PositionController::class, 'getPositions'])->name('positions.get');
        Route::get('/create', [PositionController::class, 'showCreatePositionComponent'])->name('positions.create.show');
        Route::post('/create', [PositionController::class, 'createPosition'])->name('positions.create ');
        Route::get('/edit/{position}', [PositionController::class, 'showEditPositionComponent'])->name('positions.edit.show');
        Route::patch('/edit/{position}', [PositionController::class, 'editPosition'])->name('positions.edit');
        Route::delete('/delete/{position}', [PositionController::class, 'deletePosition'])->name('positions.delete');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

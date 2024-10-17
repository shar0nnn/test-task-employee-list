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

    Route::prefix('/employees')->controller(EmployeeController::class)->group(function () {
        Route::get('/list', 'index')->name('employees.index');
        Route::get('/get', 'getEmployees')->name('employees.get');
    });

    Route::prefix('/positions')->controller(PositionController::class)->group(function () {
        Route::get('/list', 'index')->name('positions.index');
        Route::get('/get', 'getPositions')->name('positions.get');
        Route::get('/create', 'showCreatePositionComponent')->name('positions.create.show');
        Route::post('/create', 'createPosition')->name('positions.create ');
        Route::get('/edit/{position}', 'showEditPositionComponent')->name('positions.edit.show');
        Route::patch('/edit/{position}', 'editPosition')->name('positions.edit');
        Route::delete('/delete/{position}', 'deletePosition')->name('positions.delete');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

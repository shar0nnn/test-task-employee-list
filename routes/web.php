<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PositionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'showLoginComponent'])->name('login-component.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::get('/employees/list', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/positions/list', [PositionController::class, 'index'])->name('positions.index');

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class EmployeeController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('EmployeeList');
    }
}

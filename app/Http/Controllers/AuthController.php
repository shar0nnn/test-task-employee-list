<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\ResponseFactory;

class AuthController extends Controller
{
    public function showLoginComponent(): Response|ResponseFactory
    {
        return inertia('Login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

//            return redirect()->route('parsepdf.index');
        }

        return back()->withErrors(['email' => 'Невірний email чи пароль!']);
    }
}

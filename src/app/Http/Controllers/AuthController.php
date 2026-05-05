<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerView()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
{
    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    Auth::login($user);

    return redirect('/admin');
}

    public function loginView()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/admin');
    }

    return back()->withErrors([
        'email' => 'ログイン情報が登録されていません',
    ])->withInput();
}
}

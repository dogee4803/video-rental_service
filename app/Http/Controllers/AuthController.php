<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        sleep(1);

        //Validate
        $fields = $request->validate([
            'name' => ['required', 'max:255 '],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'role' => ['required'],
        ]);

        //Register
        $user = User::create($fields);

        //Login
        Auth::login($user);

        //Redirect
        return redirect()->route('home');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Введены неправильные почта и/или пароль.',
        ])->onlyInput('email');
    }
}

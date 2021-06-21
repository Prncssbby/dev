<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $req)
    {
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password], $req->remember)) {
            $req->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function register()
    {
        $user = new User();
        $user->password = Hash::make('princess');
        $user->email = 'princess';
        $user->name = 'princess';
        $user->save();
    }
}

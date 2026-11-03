<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function login()
    {
        return view('login.login');
    }
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return redirect()->route('admin.login')->with('error', 'Email ou senha inválidos');
        }
        
        if (Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            return redirect()->route('admin.index');
        }
        return redirect()->route('admin.login')->with('error', 'Email ou senha inválidos');
    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Determine if login is email or phone
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $field => $login,
            'password' => $password,
        ];

if (Auth::attempt($credentials, $request->filled('remember'))) {
    $request->session()->regenerate();

    // Redirect based on user role
    if (Auth::user()->is_admin) {
        return redirect()
            ->intended(route('admin.dashboard'))
            ->with('success', 'Karibu Admin!');
    }

    return redirect()
        ->intended(route('user.dashboard'))
        ->with('success', 'Karibu tena!');
}

        return back()->withErrors([
            'login' => 'Taarifa ulizoweka hazilingani na rekodi zetu.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Umetoka kwenye akaunti yako.');
    }
}
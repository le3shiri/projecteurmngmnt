<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'access_code' => 'required|string',
        ]);

        $user = User::where('access_code', $request->access_code)->first();

        if ($user) {
            if (!$user->is_active) {
                return back()->withErrors(['access_code' => 'Votre compte est désactivé.']);
            }

            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['access_code' => 'Code d\'accès incorrect.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('status', 'Déconnecté avec succès.');
    }
}

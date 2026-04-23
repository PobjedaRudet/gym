<?php

namespace App\Http\Controllers;

use App\Models\Moderator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ModeratorAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('moderator.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('moderator')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('moderator.dashboard');
        }

        return back()->withErrors(['email' => 'Neispravan email ili lozinka.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('moderator')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('moderator.login');
    }
}

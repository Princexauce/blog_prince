<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showRegister(Request $request)
    {
        return view('auth.register', [
            'redirect' => $request->query('redirect'),
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $loginParams = $request->filled('redirect')
            ? ['redirect' => $request->input('redirect')]
            : [];

        return redirect()
            ->route('login', $loginParams)
            ->with('success', 'Inscription réussie ! Connectez-vous maintenant avec votre compte.')
            ->withInput(['email' => $validated['email']]);
    }

    public function showLogin(Request $request)
    {
        return view('auth.login', [
            'redirect' => $request->query('redirect'),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->to($this->safeRedirect($request->input('redirect')));
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function safeRedirect(?string $redirect): string
    {
        if ($redirect && str_starts_with($redirect, url('/'))) {
            return $redirect;
        }

        return route('home');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login utama (satu gerbang login untuk Admin & Siswa).
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi login terpadu.
     * Jika admin login -> otomatis diarahkan ke Admin Panel (/admin).
     * Jika siswa login -> diarahkan ke Dashboard Siswa (/dashboard).
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return redirect()->intended(url('/admin'));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Logout dari sistem untuk semua role.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

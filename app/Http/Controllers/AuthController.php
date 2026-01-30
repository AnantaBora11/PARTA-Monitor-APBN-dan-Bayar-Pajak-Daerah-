<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/dashboard'); 
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'unique:users'], 
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'date_of_birth' => ['required', 'date'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Check citizen data
        $citizen = Penduduk::where('nik', $validated['nik'])->first();

        if (!$citizen) {
            return back()->withErrors(['nik' => 'NIK not found in citizen data.'])->withInput();
        }

        // Validate DOB match
        if ($citizen->tanggal_lahir->format('Y-m-d') !== $validated['date_of_birth']) {
             return back()->withErrors(['date_of_birth' => 'Date of birth does not match citizen records.'])->withInput();
        }

        // Validate Age (18+)
        $age = Carbon::parse($validated['date_of_birth'])->age;
        if ($age < 18) {
            return back()->withErrors(['date_of_birth' => 'You must be at least 18 years old to register.'])->withInput();
        }

        $user = User::create([
            'nik' => $validated['nik'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'date_of_birth' => $validated['date_of_birth'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'status' => 'active',
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
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
            
            // Redirect based on role
            $user = Auth::user();
            if ($user->hasRole('super_admin')) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->hasRole('store_owner')) {
                return redirect()->intended('/seller/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerCustomer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'height_cm' => 'required|numeric|min:50|max:300',
            'weight_kg' => 'required|numeric|min:10|max:300',
            'chest_circumference_cm' => 'required|numeric|min:30|max:200',
            'waist_circumference_cm' => 'required|numeric|min:30|max:200',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $user = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            ]);

            $user->assignRole('customer');

            $user->bodyProfiles()->create([
                'profile_name' => 'Profil Utama',
                'height_cm' => $validated['height_cm'],
                'weight_kg' => $validated['weight_kg'],
                'chest_circumference_cm' => $validated['chest_circumference_cm'],
                'waist_circumference_cm' => $validated['waist_circumference_cm'],
            ]);

            \Illuminate\Support\Facades\DB::commit();

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mendaftar: ' . $e->getMessage()])->withInput();
        }
    }

    public function registerSeller(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'store_name' => 'required|string|max:255|unique:stores,name',
            'store_address' => 'required|string',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $user = \App\Models\User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            ]);

            $user->assignRole('store_owner');

            $user->store()->create([
                'name' => $validated['store_name'],
                'address' => $validated['store_address'],
            ]);

            \Illuminate\Support\Facades\DB::commit();

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('/seller/dashboard');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mendaftar: ' . $e->getMessage()])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

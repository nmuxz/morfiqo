<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $user = User::where('email', $request->email)->first();
        // Delete all old tokens for this user for security (optional)
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames()
            ]
        ]);
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

            $user = User::create([
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

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Registrasi pembeli berhasil.',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()
                ]
            ], 201);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat registrasi.', 'error' => $e->getMessage()], 500);
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

            $user = User::create([
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

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Registrasi penjual berhasil.',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->getRoleNames()
                ]
            ], 201);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat registrasi.', 'error' => $e->getMessage()], 500);
        }
    }
}

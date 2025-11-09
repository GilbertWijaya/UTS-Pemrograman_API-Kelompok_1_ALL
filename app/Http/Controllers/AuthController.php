<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $admin = User::all();//mengembalikan dalam bentuk array

        return response()->json([
            "status" => true,
            "data" => $admin
        ],200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = Auth::user();

        // 🔥 Hapus semua token lama user ini
        /** @var \Laravel\Sanctum\HasApiTokens|\App\Models\User $user */
        $user->tokens()->delete();

        // Membuat token baru
        /** @var \Laravel\Sanctum\HasApiTokens|\App\Models\User $user */
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

}

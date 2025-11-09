<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::all();//mengembalikan dalam bentuk array

        return response()->json([
            "status" => true,
            "data" => $mahasiswa
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

        $mahasiswa = Auth::user();

        // 🔥 Hapus semua token lama user ini
        /** @var \Laravel\Sanctum\HasApiTokens|\App\Models\Mahasiswa $mahasiswa */
        $mahasiswa->tokens()->delete();

        // Membuat token baru
        /** @var \Laravel\Sanctum\HasApiTokens|\App\Models\Mahasiswa $mahasiswa */
        $token = $mahasiswa->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $mahasiswa
        ]);
    }

}

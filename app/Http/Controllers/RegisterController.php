<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman register.
     */
    public function index()
    {
        return view('register');
    }

    /**
     * Menangani proses registrasi user.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:6'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Simpan user baru
        $user = User::create([
            'name'     => $request->nama_lengkap,
            'email'    => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Jika berhasil
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Register berhasil!',
                'data'    => $user
            ], 201);
        }

        // Jika gagal
        return response()->json([
            'success' => false,
            'message' => 'Register gagal, coba lagi.'
        ], 500);
    }
}

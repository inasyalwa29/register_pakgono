<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Proses pengecekan login.
     */
    public function check_login(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        // Ambil data login
        $credentials = $request->only('email', 'password');
        $remember    = $request->has('remember'); // opsional

        // Proses login
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'redirect' => route('dashboard') // opsional
            ], 200);
        }

        // Jika gagal login
        return response()->json([
            'success' => false,
            'message' => 'Login gagal! Email atau password salah.'
        ], 401);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        // Hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.index');
    }
}

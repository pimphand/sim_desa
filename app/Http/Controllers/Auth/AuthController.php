<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',

        ], [
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
        ]);

        if ($data->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $data->errors(),
                'message' => 'Terjadi kesalahan',
            ]);
        }

        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'status' => false,
                'password' => 'Data tidak ditemukan',
                'message' => 'Username atau password salah'

            ]);
        }

        $request->session()->regenerate();

        return response()->json([
            'status' => true
        ]);
    }
}

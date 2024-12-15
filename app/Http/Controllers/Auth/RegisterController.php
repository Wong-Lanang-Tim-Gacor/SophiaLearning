<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ValidatesRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use ValidatesRequest;

    /**
     * Handle the registration process.
     *
     * @param  \App\Http\Requests\RegisterRequest  $registerRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(RegisterRequest $registerRequest)
    {
        // Mendapatkan data yang telah divalidasi
        $validatedData = $registerRequest->validated();

        // Hash password sebelum disimpan
        $validatedData['password'] = Hash::make($validatedData['password']);

        try {
            // Membuat user baru
            $user = User::create($validatedData);

            // Membuat token untuk user
            $token = $user->createToken('auth_token')->plainTextToken;

            // Menambahkan token ke data user
            $user['token'] = $token;

            // Mengembalikan response sukses
            return ResponseHelper::success($user, "Pendaftaran berhasil!");
        } catch (\Exception $e) {
            // Menangani error secara lebih rinci
            return ResponseHelper::error(
                $e->getMessage(),
                "Terjadi kesalahan saat pendaftaran!",
                500
            );
        }
    }
}

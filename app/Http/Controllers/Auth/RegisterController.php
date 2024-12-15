<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ValidatesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use ValidatesRequest;
    public function handle(RegisterRequest $registerRequest)
    {
        try {
            $user = User::create($registerRequest->validated());
            $token = $user->createToken('auth_token')->plainTextToken;
            $user['token'] = $token;
            return ResponseHelper::success($user, "Pendaftaran berhasil!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "Terjadi kesalahan!", 500);
        }
    }
}
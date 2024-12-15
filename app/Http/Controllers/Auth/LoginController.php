<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function handle(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseHelper::error($user, "Email atau kata sandi salah!");
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $user['token'] = $token;

        return ResponseHelper::success($user, "Login berhasil!");
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Interfaces\UserInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class EditProfileController extends Controller
{

    private UserInterface $user;
    private UserService  $userService;
    private $userLogin;

    public function __construct(UserInterface $user, UserService $userService)
    {
        $this->user = $user;
        $this->userService = $userService;
        $this->userLogin = auth()->user();
    }

    public function showProfile()
    {
        try {
            $user = $this->user->show($this->userLogin);
            return ResponseHelper::success($user, 'Sukses mengambil data!');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function updateProfile(UserUpdateRequest $request)
    {
        try {
            // Jika ada input password, verifikasi current_password terlebih dahulu
            if ($request->filled('password')) {
                if (!Hash::check($request->input('current_password'), $this->userLogin->password)) {
                    return ResponseHelper::error(null, 'Kata sandi tidak cocok.');
                }

                // Enkripsi password baru
                $request->merge(['password' => Hash::make($request->input('password'))]);
            }

            $userData = $request->validated();
            if ($request->hasFile('photo_profile')) {
                $imagePath = $this->userService->validateAndUpload('profile-photos', $request->file('photo_profile'), $this->userLogin->photo_profile);
                $userData['photo_profile'] = $imagePath ?? 'default.jpg';
            }
            $this->user->update($this->userLogin->id, $userData);
            return ResponseHelper::success($this->user->show($this->userLogin->id), 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }
}

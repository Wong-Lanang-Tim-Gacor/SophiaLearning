<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Interfaces\UserInterface;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;

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
            return ResponseHelper::success($user, 'Profile retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function updateProfile(UserUpdateRequest $request)
    {
        try {
            $userData = $request->validated();
            if ($request->hasFile('photo_profile')) {
                $imagePath = $this->userService->validateAndUpload('profile-photos', $request->file('photo_profile'), $this->user->photo_profile);
                $userData['photo_profile'] = $imagePath ?? 'default.jpg';
            }

            $this->user->update($this->user->id, $userData);

            return ResponseHelper::success($this->user->show($this->userLogin), 'Profile updated successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }
}

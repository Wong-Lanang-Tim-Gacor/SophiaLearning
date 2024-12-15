<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ClassroomRequest;
use App\Http\Requests\ClassroomUpdateRequest;
use App\Services\ClassroomService;


class ClassroomController extends Controller
{
    private ClassroomInterface $classroom;
    private ClassroomService  $classroomService;
    private $user;

    public function __construct(ClassroomInterface $classroom, ClassroomService $classroomService)
    {
        $this->classroom = $classroom;
        $this->classroomService = $classroomService;
        $this->user = auth()->user();
    }


    public function index()
    {
        try {
            $classroom = $this->classroom->get();
            return ResponseHelper::success($classroom, 'Sukses mengambil data!.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function store(ClassroomRequest $request)
    {
        try {
            if ($request->hasFile('background_image')) {
                $imagePath = $this->classroomService->validateAndUpload('background-classroom', $request->file('background_image'));
            }

            $classroomData = array_merge($request->validated(), ['user_id' => $this->user->id]);
            $classroom = $this->classroom->store($classroomData);

            $this->classroom->update($classroom->id, [
                'background_image' => $imagePath ?? 'default-background.jpg',
            ]);
            return ResponseHelper::success($this->classroom->show($classroom->id), 'Kelas berhasil ditambahkan!', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($request->all(), $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $classroom = $this->classroom->show($id);
            return ResponseHelper::success($classroom, 'Sukses mengambil data!.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function update(ClassroomUpdateRequest $request, string $id)
    {
        try {
            $classroomData = $request->validated();
            if ($request->hasFile('background_image')) {
                $imagePath = $this->classroomService->validateAndUpload('background-classroom', $request->file('background_image'));
                $classroomData['background_image'] = $imagePath ?? 'default-background.jpg';
            }
            $this->classroom->update($id, $classroomData);
            return ResponseHelper::success($this->classroom->show($id), 'Kelas berhasil diperbarui!');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->classroom->delete($id);
            return ResponseHelper::success(null, "Kelas berhasil dihapus!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }


    public function getJoinedClasses()
    {
        try {
            $classes = $this->classroom->getJoinedClasses($this->user->id);
            return ResponseHelper::success($classes, 'Sukses mengambil data!');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }


    public function getArchivedClasses()
    {
        try {
            $classes = $this->classroom->getArchivedClasses($this->user->id);
            return ResponseHelper::success($classes, 'Sukses mengambil data!');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }


    public function joinClass(string $classroomCode)
    {
        try {
            $result = $this->classroom->joinClass($classroomCode, $this->user->id);
        } catch (\Exception $e) {
            return ResponseHelper::error(null,  $e->getMessage());
        }

        if ($result === 'AlreadyEnrolled') return ResponseHelper::error(null, 'Anda telah terdaftar pada kelas ini!');

        return ResponseHelper::success($result, 'Berhasil bergabung!');
    }


    public function leaveClass(int $classroomId)
    {
        try {
            $result = $this->classroom->leaveClass($classroomId, $this->user->id);
        } catch (\Exception $e) {
            return ResponseHelper::error(null,  $e->getMessage());
        }

        if ($result === 'NotEnrolled') return ResponseHelper::error(null, 'Anda tidak tergabung!');

        return ResponseHelper::success(null, 'Berhasil meninggalkan kelas!');
    }
}

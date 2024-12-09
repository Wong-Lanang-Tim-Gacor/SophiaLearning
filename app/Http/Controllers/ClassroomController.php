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

    public function __construct(ClassroomInterface $classroom, ClassroomService $classroomService)
    {
        $this->classroom = $classroom;
        $this->classroomService = $classroomService;
    }


    public function index()
    {
        try {
            $classroom = $this->classroom->get();
            return ResponseHelper::success($classroom, 'Classroom retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function store(ClassroomRequest $request)
    {
        try {
            if($request->hasFile('background_image')) {
                $imagePath = $this->classroomService->validateAndUpload('background-classroom', $request->file('background_image'));
            }
            $classroom = $this->classroom->store($request->validated());
            $this->classroom->update($classroom->id, [
                'background_image' => $imagePath ?? 'default-background.jpg',
            ]);
            return ResponseHelper::success($this->classroom->show($classroom->id), 'Classroom created successfully.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($request->all(), $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $classroom = $this->classroom->show($id);
            return ResponseHelper::success($classroom, 'Classroom retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function update(ClassroomUpdateRequest $request, string $id)
    {
        try {
            $data = [];
            if($request->hasFile('background_image')) {
                $imagePath = $this->classroomService->validateAndUpload('background-classroom', $request->file('background_image'));
                $data = [
                    ...$request->validated(),
                    'background_image' => $imagePath ?? 'default-background.jpg',
                ];
            }
            $this->classroom->update($id, $data);
            return ResponseHelper::success($this->classroom->show($id), 'Classroom updated successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->classroom->delete($id);
            return ResponseHelper::success(null, "Classroom deleted successfully.");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }


    public function getJoinedClasses()
    {
        try {
            $userId = auth()->user()->id;
            $classes = $this->classroom->getJoinedClasses($userId);
            return ResponseHelper::success($classes, 'Classes retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }


    public function getCreatedClasses()
    {
        try {
            $userId = auth()->user()->id;
            $classes = $this->classroom->getCreatedClasses($userId);
            return ResponseHelper::success($classes, 'Created classes retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function joinClass(int $classroomId)
    {
        $userId = auth()->user()->id;
        $result = $this->classroom->joinClass($classroomId, $userId);

        if ($result === 'ClassroomNotFound') return ResponseHelper::error(null, 'Classroom not found.');

        if ($result === 'AlreadyEnrolled') return ResponseHelper::error(null, 'You are already enrolled in this class.');

        return ResponseHelper::success(null, 'Successfully joined the class.');
    }


    public function leaveClass(int $classroomId)
    {
        $userId = auth()->user()->id;
        $result = $this->classroom->leaveClass($classroomId, $userId);

        if ($result === 'ClassroomNotFound') return ResponseHelper::error(null, 'Classroom not found.');

        if ($result === 'NotEnrolled') return ResponseHelper::error(null, 'You are not enrolled in this class.');

        return ResponseHelper::success(null, 'Successfully left the class.');
    }
}

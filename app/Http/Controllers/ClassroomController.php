<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ClassroomRequest;
use App\Http\Requests\ClassroomUpdateRequest;

class ClassroomController extends Controller
{
    private ClassroomInterface $classroom;

    public function __construct(ClassroomInterface $classroom)
    {
        $this->classroom = $classroom;
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
            $classroom = $this->classroom->store($request->validated());
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
            $this->classroom->update($id, $request->validated());
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
}

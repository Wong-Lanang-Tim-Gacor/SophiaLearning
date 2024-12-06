<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ClassroomRequest;
use App\Http\Requests\ClassroomUpdateRequest;
use App\Models\Classroom;
use App\Models\StudentHasClass;
use GuzzleHttp\Psr7\Request;

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

    public function joinClass($classroomId)
    {
        $user = auth()->user();
        $classroom = Classroom::find($classroomId);

        if (!$classroom) {
            return ResponseHelper::error(null, "Classroom not found.");
        }

        // Cek apakah user sudah bergabung ke kelas
        $existingStudent = $classroom->students()->where('student_id', $user->id)->first();

        if ($existingStudent) {
            return ResponseHelper::error(null, "You are already enrolled in this class fuck.");
        }

        // Menambahkan user ke kelas melalui pivot table (relasi many-to-many)
        $classroom->students()->attach($user->id);

        return ResponseHelper::success(null, "Successfully joined the class.");
    }

    public function leaveClass($classroomId)
    {
        $user = auth()->user();
        $classroom = Classroom::find($classroomId); // Cari classroom berdasarkan ID

        if (!$classroom) {
            return ResponseHelper::error(null, "Classroom not found.");
        }

        // Cek apakah user sudah tergabung dalam kelas
        $studentClass = StudentHasClass::where('classroom_id', $classroomId)
            ->where('student_id', $user->id)
            ->first();

        if (!$studentClass) {
            return ResponseHelper::error(null, 'You are not a member of this class.');
        }

        // Menghapus siswa dari kelas
        $studentClass->delete();

        return ResponseHelper::success(null, 'Successfully left the class.');
    }

    public function getJoinedClasses()
    {
        $user = auth()->user();

        // Mengambil semua kelas yang diikuti oleh user berdasarkan hubungan pada pivot table
        $classes = $user->classroomsJoined()->with('teacher:id,name')->get();

        return ResponseHelper::success($classes, 'Classes retrieved successfully.');
    }

    public function getCreatedClasses()
    {
        $user = auth()->user();

        // Mengambil kelas-kelas yang dibuat oleh guru
        $classes = $user->classroomsCreated()->withCount('students')->get();

        return ResponseHelper::success($classes, 'Created classes retrieved successfully.');
    }
}

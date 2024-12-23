<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Models\Classroom;
use App\Services\ClassroomService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class ClassroomRepository extends BaseRepository implements ClassroomInterface
{
    public function __construct(Classroom $classroom, ClassroomService $classroomService)
    {
        $this->model = $classroom;
    }

    public function get(): mixed
    {
        return $this->model
            ->query()
            ->withCount('students')
            ->with(['teacher:id,name']) // hanya nama guru
            ->get();
    }

    public function show(mixed $id): mixed
    {
        return $this->model
            ->query()
            ->withCount('students')
            ->with(['students', 'teacher'])
            ->findOrFail($id);
    }

    public function store(mixed $data): mixed
    {
        $randomIdentifier = Str::random(rand(6, 7));
        $data['identifier_code'] = $randomIdentifier;
        return $this->model
            ->query()
            ->create($data);
    }

    public function update(mixed $id, array $data): mixed
    {
        return $this->show($id)
            ->update($data);
    }

    public function delete(mixed $id): mixed
    {
        try {
            $this->show($id)->delete($id);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) return false;
        }

        return true;
    }

    public function getArchivedClasses(mixed $userId): mixed
    {
        return $this->model
            ->query()
            ->getJoinedClasses($userId, isArchived: true)->get();
    }

    public function getJoinedClasses(mixed $userId): mixed
    {
        return $this->model
            ->query()
            ->getJoinedClasses($userId)->get();
    }

    public function getCreatedClasses(mixed $userId): mixed
    {
        return $this->model
            ->query()
            ->getCreatedClasses($userId)->get();
    }

    public function joinClass(string $classroomCode, mixed $userId)
    {
        $classroom = Classroom::query()->where('identifier_code', $classroomCode)->with(['students', 'teacher'])->firstOrFail();

        if ($classroom->isStudentEnrolled($userId)) return 'AlreadyEnrolled';
        $classroom->students()->attach($userId);
        return $classroom;
    }

    public function leaveClass(int $classroomId, mixed $userId)
    {
        $classroom = Classroom::findOrFail($classroomId);

        if (!$classroom->isStudentEnrolled($userId)) return 'NotEnrolled';

        $classroom->students()->detach($userId);
        return 'Success';
    }
}

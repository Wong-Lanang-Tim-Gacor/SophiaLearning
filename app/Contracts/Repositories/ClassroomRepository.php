<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Models\Classroom;
use App\Services\ClassroomService;
use Illuminate\Database\QueryException;

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
            ->with(['students', 'teacher', 'topics:id,topic_name,classroom_id'])
            ->findOrFail($id);
    }

    public function store(mixed $data): mixed
    {
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
        return $this->show($id)
            ->delete();
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

    public function joinClass(int $classroomId, mixed $userId)
    {
        $classroom = Classroom::find($classroomId);

        if (!$classroom) return 'ClassroomNotFound';

        if ($classroom->isStudentEnrolled($userId)) return 'AlreadyEnrolled';

        $classroom->students()->attach($userId);
        return 'Success';
    }

    public function leaveClass(int $classroomId, mixed $userId)
    {
        $classroom = Classroom::find($classroomId);

        if (!$classroom) return 'ClassroomNotFound';

        if (!$classroom->isStudentEnrolled($userId)) return 'NotEnrolled';

        $classroom->students()->detach($userId);
        return 'Success';
    }
}

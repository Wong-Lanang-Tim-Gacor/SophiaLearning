<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Models\Classroom;
use Illuminate\Database\QueryException;

class ClassroomRepository extends BaseRepository implements ClassroomInterface
{
    public function __construct(Classroom $classroom)
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

    public function store(array $data): mixed
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
}

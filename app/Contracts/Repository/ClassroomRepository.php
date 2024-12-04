<?php

namespace App\Contracts\Repository;

use App\Contracts\Interfaces\ClassroomInterface;
use App\Models\Classroom;
use Illuminate\Database\QueryException;

class ClassroomRepository extends BaseRepository implements ClassroomInterface
{
    public function __construct(Classroom $classroom)
    {
        $this->model = $classroom;
    }
    public function get()
    {
        return $this->model
            ->query()
            ->withCount('student_class')
            ->with(['assignments', 'teacher'])
            ->get();
    }
    public function show(mixed $id)
    {
        return $this->model
            ->query()
            ->with(['student_class', 'assignments', 'teacher'])
            ->findOrFail($id);
    }
    public function create(array $data)
    {
        try {
            $this->model->create($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function update(mixed $id, array $data)
    {
        try {
            $this->show($id)->update($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function delete(mixed $id)
    {
        try {
            $this->show($id)->delete();
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) return false;
        }
        return true;
    }
}

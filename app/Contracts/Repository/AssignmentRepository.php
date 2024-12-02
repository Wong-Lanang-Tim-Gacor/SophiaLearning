<?php

namespace App\Contracts\Repository;

use App\Contracts\Interface\AssignmentInterface;
use App\Models\Assignment;
use Illuminate\Database\QueryException;

class AssignmentRepository extends BaseRepository implements AssignmentInterface
{
    public function __construct(Assignment $assignment)
    {
        $this->model = $assignment;
    }

    public function get()
    {
        return $this->model
            ->query()
            ->with(['topic','classroom'])
            ->get();
    }

    public function show(mixed $id)
    {
        return $this->model->query()
            ->with(['topic','classroom','studentAnswer','studentAnswer.attachment'])
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->query()->create($data);
    }

    public function update(mixed $id, array $data)
    {
        return $this->show($id)->update($data);
    }

    public function delete(mixed $id)
    {
        try {
            return $this->show($id)->delete();
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) return false;
        }
        return true;
    }
}

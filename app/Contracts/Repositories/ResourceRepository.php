<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ResourceInterface;
use App\Models\Resource;
use Illuminate\Database\QueryException;

class ResourceRepository extends BaseRepository implements ResourceInterface
{
    public function __construct(Resource $resource)
    {
        $this->model = $resource;
    }

    public function get()
    {
        return $this->model
            ->query()
            ->with(['classroom'])
            ->withAvg('answer', 'point')
            ->get();
    }

    public function show(mixed $id)
    {
        return $this->model->query()
            ->with(['classroom', 'attachment', 'answer', 'answer.attachments'])
            ->findOrFail($id);
    }

    public function store(array $data)
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

    public function getResourceByClassId(mixed $id)
    {
        return $this->model
            ->query()
            ->with(['classroom', 'answer', 'answer.attachments'])
            ->where('classroom_id', $id)
            ->get();
    }

    public function getAveragePoint(mixed $id)
    {
        $dataWithAverage = $this->model->query()
            ->with(['classroom'])
            ->withAvg('answer', 'point')
            ->findOrFail($id);
        return number_format($dataWithAverage->student_answer_avg_point, 2);
    }
}
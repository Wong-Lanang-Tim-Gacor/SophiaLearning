<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AssignmentInterface;
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
            ->with(['classroom'])
            ->withAvg('answer', 'point')
            ->get();
    }

    public function show(mixed $id)
    {
        return $this->model->query()
            ->with(['classroom','answer','answer.attachments'])
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

    public function getAssignmentByClassId(mixed $id)
    {
        return $this->model
            ->query()
            ->with(['topic','classroom','answer','answer.attachments'])
            ->where('classroom_id', $id)
            ->get();
    }

    public function getAveragePoint(mixed $id)
    {
        try{
            $dataWithAverage = $this->model->query()
                ->with(['topic', 'classroom'])
                ->withAvg('answer', 'point')
                ->findOrFail($id);
            return number_format($dataWithAverage->student_answer_avg_point,2);
        }catch (QueryException $e){
            return $e->getMessage();
        }

    }

    public function getAssignmentByTopic(mixed $id)
    {
        return $this->model
            ->query()
            ->with(['topic','classroom','answer','answer.attachments'])
            ->where('topic_id', $id)
            ->get();
    }
}

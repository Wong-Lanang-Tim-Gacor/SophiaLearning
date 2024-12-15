<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ResourceInterface;
use App\Enums\ResourceTypeEnum;
use App\Models\Classroom;
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
            ->with(['classroom:id,class_name'])
            ->get();
    }

    public function getUserAssignments($userId): mixed
    {
        return $this->model
            ->query()
            ->ofAssignmentType()
            ->fromUserClasses($userId)
            ->with(['classroom:id,class_name'])
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function getAnnouncements(mixed $id)
    {
        return $this->model
            ->query()
            ->ofAnnouncementType()
            ->with(['classroom:id,class_name'])
            ->findOrFail($id);
    }

    public function getMaterials(mixed $id)
    {
        return $this->model
            ->query()
            ->ofMaterialType()
            ->with(['classroom:id,class_name'])
            ->findOrFail($id);
    }

    public function getAssignments(mixed $id)
    {
        return $this->model
            ->query()
            ->where('type', ResourceTypeEnum::ASSIGNMENT)
            ->withAvg('answer', 'point')
            ->with(['classroom:id,class_name'])
            ->findOrFail($id);
    }

    public function show(mixed $id)
    {
        $data = $this->model->query()
            ->with([
                'classroom',
                'classroom.teacher',
                'chats' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'chats.user',
                'attachment',
                'answer' => function ($query) {
                    $query->where('user_id', auth()->user()->id)->first();
                },
                'answer.attachments'
            ])
            ->findOrFail($id)
            ->toArray();
        $data['answer'] = $data['answer'][0] ?? [];
        return $data;
    }

    public function findForQuery(mixed $id)
    {
        return $this->model->query()
            ->with([
                'attachment',
            ])
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->model->query()->create($data);
    }

    public function update(mixed $id, array $data)
    {
        return $this->findForQuery($id)->update($data);
    }

    public function delete(mixed $id)
    {
        try {
            return $this->findForQuery($id)->delete();
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) return false;
        }
        return true;
    }

    public function getResourceByClassId(mixed $id)
    {
        return Classroom::query()
            ->with(['resources' => function ($query) {
                $query->orderBy('id', 'desc'); // Order by resource_id
            }])
            ->selectRaw('classrooms.*, CASE WHEN user_id = ? THEN true ELSE false END as is_teacher', [auth()->user()->id])
            ->find($id);
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

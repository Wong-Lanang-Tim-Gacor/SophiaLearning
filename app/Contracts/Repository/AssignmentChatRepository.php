<?php

namespace App\Contracts\Repository;

use App\Contracts\Interfaces\AssignmentChatInterface;
use App\Models\AssignmentChat;
use App\Models\Classroom;
use Illuminate\Database\QueryException;

class AssignmentChatRepository extends BaseRepository implements AssignmentChatInterface
{
    public function __construct(AssignmentChat $chat)
    {
        $this->model = $chat;
    }
    public function get(mixed $assignmentId)
    {
        return $this->model
            ->query()
            ->with(['user'])
            ->where('assignment_id', $assignmentId)
            ->get();
    }
    public function show(mixed $id)
    {
        return $this->model
            ->query()
            ->with(['user'])
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

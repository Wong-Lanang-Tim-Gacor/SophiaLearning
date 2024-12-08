<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AnswerInterface;
use App\Models\Answer;
use Illuminate\Database\QueryException;

class AnswerRepository extends BaseRepository implements AnswerInterface
{
    public function __construct(Answer $answer)
    {
        $this->model = $answer;
    }

    public function get(): mixed
    {
        return $this->model
            ->query()
            ->with(['attachments','student']) // hanya nama kelas
            ->get();
    }

    public function show(mixed $id): mixed
    {
        return $this->model
            ->query()
            ->with(['attachments','student'])  // hanya nama kelas
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
        try {
            $this->show($id)->delete($id);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) return false;
        }

        return true;
    }
}

<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\TopicInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Topic;

class TopicRepository extends BaseRepository implements TopicInterface
{
    public function __construct(Topic $topic)
    {
        $this->model = $topic;
    }

    public function get(): mixed
    {
        return $this->model
            ->query()
            ->with(['classroom:id,class_name']) // hanya nama kelas
            ->get();
    }

    public function show(mixed $id): mixed
    {
        return $this->model
            ->query()
            ->with(['classroom:id,class_name']) // hanya nama kelas
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
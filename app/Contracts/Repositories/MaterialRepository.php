<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\MaterialInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Material;

class MaterialRepository extends BaseRepository implements MaterialInterface
{
    public function __construct(Material $material)
    {
        $this->model = $material;
    }

    public function get(): mixed
    {
        return $this->model
            ->query()
            ->with(['classroom:id,class_name', 'topic:id,topic_name']) 
            ->get();
    }

    public function show(mixed $id): mixed
    {
        return $this->model
            ->query()
            ->with(['classroom:id,class_name', 'topic:id,topic_name'])
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
}

<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\ChatInterface;
use App\Models\Chat;
use App\Models\Material;

class ChatRepository extends BaseRepository implements ChatInterface
{
    public function __construct(Chat $chat)
    {
        $this->model = $chat;
    }
    public function get(): mixed
    {
        return $this->model
            ->query()
            ->with(['resource','user'])
            ->get();
    }

    public function show(mixed $id): mixed
    {
        return $this->model
            ->query()
            ->with(['user'])
            ->findOrFail($id);
    }

    public function store(mixed $data): mixed
    {
        $data['user_id'] = auth()->user()->id;
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

    public function getChatByResource(mixed $resourceId)
    {
        return $this->model
            ->query()
            ->with(['resource','user'])
            ->where('resource_id', $resourceId)
            ->orderBy('id','desc')
            ->get();
    }
}

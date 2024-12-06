<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\TopicInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\TopicRequest;
use App\Http\Requests\TopicUpdateRequest;

class TopicController extends Controller
{
    private TopicInterface $topic;

    public function __construct(TopicInterface $topic)
    {
        $this->topic = $topic;
    }

    public function index()
    {
        try {
            $topic = $this->topic->get();
            return ResponseHelper::success($topic, 'Topic retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    
    public function store(TopicRequest $request)
    {
        try {
            $topic = $this->topic->store($request->validated());
            return ResponseHelper::success($this->topic->show($topic->id), 'Topic created successfully.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($request->all(), $e->getMessage());
        }
    }

    
    public function show(string $id)
    {
        try {
            $topic = $this->topic->show($id);
            return ResponseHelper::success($topic, 'Topic retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    
    public function update(TopicUpdateRequest $request, string $id)
    {
        try {
            $this->topic->update($id, $request->validated());
            return ResponseHelper::success($this->topic->show($id), 'Topic updated successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    
    public function destroy(string $id)
    {
        try {
            $this->topic->delete($id);
            return ResponseHelper::success(null, "Topic deleted successfully.");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }
}

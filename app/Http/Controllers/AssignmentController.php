<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AssignmentInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AssignmentRequest;
use App\Models\AssignmentAttachment;
use App\Services\AssignmentService;
use App\Traits\ValidatesRequest;

class AssignmentController extends Controller
{
    use ValidatesRequest;

    private AssignmentInterface $assignment;
    private AssignmentService $assignmentService;

    public function __construct(
        AssignmentInterface $assignment,
        AssignmentService $assignmentService
    )
    {
        $this->assignment = $assignment;
        $this->assignmentService = $assignmentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::success($this->assignment->get(), "success retrieved data!");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignmentRequest $request)
    {
        try {
            $saveAssignment = $this->assignment->store($request->validated());
            if($request->hasFile('attachments')){
                $this->assignmentService->storeAttachment($saveAssignment->id,'answer_attachments',$request->validated(), new AssignmentAttachment(), 'assignment_id');
            }
            return ResponseHelper::success($saveAssignment, "success retrieved data!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "failed retrieved data!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return ResponseHelper::success($this->assignment->show($id), "success retrieved data!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "failed retrieved data!");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssignmentRequest $request, string $id)
    {
        try {
            $this->assignment->update($id, $request->validated());
            return ResponseHelper::success($this->assignment->show($id), "success updating data!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "failed updating data!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->assignment->delete($id);
            return ResponseHelper::success(message: "success deleting data!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "failed deleting data!");
        }
    }

    public function getAveragePoint(string $id)
    {
        $data = [
            'average_score' => $this->assignment->getAveragePoint($id),
        ];
        return ResponseHelper::success($data, "success retrieved data!");
    }

    public function getAssignmentByClassId(string $class_id)
    {
        $assignment = $this->assignment->getAssignmentByClassId($class_id);
        return ResponseHelper::success($assignment, "success retrieved data!");
    }

    public function getAssignmentByTopicId(string $id)
    {
        $assignment = $this->assignment->getAssignmentByTopic($id);
        return ResponseHelper::success($assignment, "success retrieved data!");
    }
}

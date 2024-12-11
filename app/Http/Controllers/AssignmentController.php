<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AssignmentInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AssignmentRequest;
use App\Models\AssignmentAttachment;
use App\Services\AssignmentService;

class AssignmentController extends Controller
{

    private AssignmentInterface $assignment;
    private AssignmentService $assignmentService;

    public function __construct(
        AssignmentInterface $assignment,
        AssignmentService $assignmentService
    ) {
        $this->assignment = $assignment;
        $this->assignmentService = $assignmentService;
    }

    public function index()
    {
        try {
            $assignments = $this->assignment->get();
            return ResponseHelper::success($assignments, 'Assignment retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function store(AssignmentRequest $request)
    {
        try {
            $saveAssignment = $this->assignment->store($request->validated());
            if ($request->hasFile('attachments')) {
                $this->assignmentService->storeAttachment($saveAssignment->id, 'answer_attachments', $request->validated(), new AssignmentAttachment(), 'assignment_id');
            }
            return ResponseHelper::success($saveAssignment, "success retrieved data!");
        } catch (\Exception $e) {
            return ResponseHelper::error($request->all(), $e->getMessage());
        }
    }


    public function show(string $id)
    {
        try {
            return ResponseHelper::success($this->assignment->show($id), "success retrieved data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function update(AssignmentRequest $request, string $id)
    {
        try {
            $this->assignment->update($id, $request->validated());
            return ResponseHelper::success($this->assignment->show($id), "success updating data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->assignment->delete($id);
            return ResponseHelper::success(message: "success deleting data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function getAveragePoint(string $id)
    {
        try {
            $data = [
                'average_score' => $this->assignment->getAveragePoint($id),
            ];
            return ResponseHelper::success($data, "Success retrieved data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function getAssignmentByClassId(string $class_id)
    {
        try {
            $assignment = $this->assignment->getAssignmentByClassId($class_id);
            return ResponseHelper::success($assignment, "Success retrieved data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function getAssignmentByTopicId(string $id)
    {
        try {
            $assignment = $this->assignment->getAssignmentByTopic($id);
            return ResponseHelper::success($assignment, "success retrieved data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }
}

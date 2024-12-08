<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\AnswerInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AnswerRequest;
use App\Models\Answer;
use App\Models\AnswerAttachment;
use App\Services\AnswerService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    private AnswerInterface $answer;
    private AnswerService $answerService;

    public function __construct(AnswerInterface $answer, AnswerService $answerService)
    {
        $this->answer = $answer;
        $this->answerService = $answerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::success($this->answer->get(), "success retrieved data!");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnswerRequest $request)
    {
        try {
            $request->merge([
                    'user_id' => auth()->user()->id
                ]);
            $saveAnswer = $this->answer->store($request->all());
            $this->answerService->storeAttachment($saveAnswer->id,'answer_attachments',$request->validated(), new AnswerAttachment(), 'answer_id');
            return ResponseHelper::success($this->answer->show($saveAnswer->id), "success retrieved data!");
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
            return ResponseHelper::success($this->answer->show($id), "success retrieved data!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "failed retrieved data!");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnswerRequest $request, string $id)
    {
        try {
            $this->answer->update($id, $request->validated());
            $this->answerService->storeAttachment($id,'answer_attachments',$request->validated(), new AnswerAttachment(), 'answer_id');
            return ResponseHelper::success($request->validated(), "success updating data!");
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
            $this->answer->delete($id);
            return ResponseHelper::success(message: "success deleting data!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "failed deleting data!");
        }
    }

}

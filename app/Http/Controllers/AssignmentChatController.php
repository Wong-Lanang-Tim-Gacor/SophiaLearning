<?php

namespace App\Http\Controllers;

use App\Contracts\Interface\AssignmentChatInterface;
use App\Contracts\Interface\AssignmentInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\AssignmentChatRequest;
use App\Http\Requests\AssignmentRequest;
use App\Traits\ValidatesRequest;
use Illuminate\Http\Request;

class AssignmentChatController extends Controller
{
    use ValidatesRequest;

    private AssignmentChatInterface $assignmentChat;

    public function __construct(
        AssignmentChatInterface $assignmentChat
    )
    {
        $this->assignmentChat = $assignmentChat;
    }

    /**
     * Display a listing of the resource.
     */
    public function getChatByAssignmentId(string $assignmentId)
    {
        return ResponseHelper::success($this->assignmentChat->get($assignmentId), "Sukses mengambil data!");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignmentChatRequest $request)
    {
        try {
            $this->assignmentChat->create($request->validated());
            return ResponseHelper::success($request->validated(), "Pesan berhasil dikirim!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "Terjadi kesalahan!");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return ResponseHelper::success($this->assignmentChat->show($id), "Sukses mengambil data!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "Terjadi kesalahan!");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssignmentChatRequest $request, string $id)
    {
        try {
            $this->assignmentChat->update($id, $request->validated());
            return ResponseHelper::success($request->validated(), "Pesan berhasil diperbarui!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "Terjadi kesalahan!");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->assignmentChat->delete($id);
            return ResponseHelper::success(message: "Pesan berhasil dihapus!");
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage(), "Terjadi kesalahan!");
        }
    }
}

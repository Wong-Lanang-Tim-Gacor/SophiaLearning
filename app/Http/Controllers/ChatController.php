<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ChatInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ChatRequest;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private ChatInterface $chat;
    public function __construct(
        ChatInterface $chat
    )
    {
        $this->chat = $chat;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ChatRequest $request)
    {
        try{
            $saveChat = $this->chat->store($request->validated());
            return ResponseHelper::success($this->chat->show($saveChat->id), 'Pesan berhasil dikirim!');
        }catch (\Exception $exception){
            return ResponseHelper::error($exception->getMessage(), 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getChatByResource(mixed $resourceId)
    {
        return ResponseHelper::success($this->chat->getChatByResource($resourceId),'Sukses mengambil data!');
    }
}

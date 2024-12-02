<?php

namespace App\Http\Controllers;

use App\Contracts\Interface\ClassroomInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ClassroomRequest;
use App\Traits\ValidatesRequest;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    use ValidatesRequest;
    private ClassroomInterface $classroom;

    public function __construct(
        ClassroomInterface $classroom
    ) {
        $this->classroom = $classroom;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::success($this->classroom->get(), "success retried data!");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassroomRequest $request)
    {
        try {
            $this->classroom->create($request->validated());
            return ResponseHelper::success($this->classroom->get(), "success created data!");
        } catch (\Exception $exception) {
            return ResponseHelper::error(null, $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return ResponseHelper::success($this->classroom->show($id), "success retried data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClassroomRequest $request, string $id)
    {
        try {
            $this->classroom->update($id, $request->validated());
            return ResponseHelper::success($this->classroom->show($id), "success updated data!");
        } catch (\Exception $exception) {
            return ResponseHelper::error(null, $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->classroom->delete($id);
            return ResponseHelper::success("success deleted data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }
}

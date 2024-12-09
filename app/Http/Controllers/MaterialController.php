<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\MaterialInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\MaterialRequest;
use App\Http\Requests\MaterialUpdateRequest;

class MaterialController extends Controller
{
    private MaterialInterface $material;

    public function __construct(MaterialInterface $material)
    {
        $this->material = $material;
    }

    public function index()
    {
        try {
            $materials = $this->material->get();
            return ResponseHelper::success($materials, 'Materials retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function store(MaterialRequest $request)
    {
        try {
            $material = $this->material->store($request->validated());
            return ResponseHelper::success($this->material->show($material->id), 'Material created successfully.', 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($request->all(), $e->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $material = $this->material->show($id);
            return ResponseHelper::success($material, 'Material retrieved successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function update(MaterialUpdateRequest $request, string $id)
    {
        try {
            $this->material->update($id, $request->validated());
            return ResponseHelper::success($this->material->show($id), 'Material updated successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->material->delete($id);
            return ResponseHelper::success(null, 'Material deleted successfully.');
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }
}

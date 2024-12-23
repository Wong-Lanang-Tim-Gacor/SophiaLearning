<?php

namespace App\Http\Controllers;

use App\Contracts\Interfaces\ResourceInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ResourceRequest;
use App\Http\Requests\ResourceUpdateRequest;
use App\Models\ResourceAttachment;
use App\Services\ResourceService;

class ResourceController extends Controller
{

    private ResourceInterface $resource;
    private ResourceService $resourceService;

    public function __construct(
        ResourceInterface $resource,
        ResourceService $resourceService
    ) {
        $this->resource = $resource;
        $this->resourceService = $resourceService;
    }

    public function index()
    {
        try {
            $resources = $this->resource->get();
            return ResponseHelper::success($resources, 'Sukses mengambil data.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function getAnnouncements(string $class_id)
    {
        try {
            $resources = $this->resource->getAnnouncements($class_id);
            return ResponseHelper::success($resources, 'Sukses mengambil data.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function getMaterials(string $class_id)
    {
        try {
            $resources = $this->resource->getMaterials($class_id);
            return ResponseHelper::success($resources, 'Sukses mengambil data.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function getAssignments(string $class_id)
    {
        try {
            $resources = $this->resource->getAssignments($class_id);
            return ResponseHelper::success($resources, 'Sukses mengambil data.');
        } catch (\Exception $e) {
            return ResponseHelper::error([], $e->getMessage());
        }
    }

    public function store(ResourceRequest $request)
    {
        try {
            $saveResource = $this->resource->store($request->validated());
            if ($request->hasFile('attachments')) {
                $this->resourceService->storeAttachment($saveResource->id, 'resource_attachments', $request->validated(), new ResourceAttachment(), 'resource_id');
            }
            return ResponseHelper::success($this->resource->getResourceByClassId($request->classroom_id), "Data berhasil diunggah!", 201);
        } catch (\Exception $e) {
            return ResponseHelper::error($request->all(), $e->getMessage());
        }
    }


    public function show(string $id)
    {
        try {
            return ResponseHelper::success($this->resource->show($id), "Sukses mengambil data.");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function update(ResourceUpdateRequest $request, string $id)
    {
        try {
            $this->resource->update($id, $request->validated());
            if ($request->hasFile('attachments')) {
                $this->resourceService->storeAttachment($id, 'resource_attachments', $request->validated(), new ResourceAttachment(), 'resource_id');
            }
            return ResponseHelper::success($this->resource->show($id), "Data berhasil diperbarui!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->resource->delete($id);
            return ResponseHelper::success(message: "Data berhasil dihapus!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function getAveragePoint(string $id)
    {
        try {
            $data = [
                'average_score' => $this->resource->getAveragePoint($id),
            ];
            return ResponseHelper::success($data, "Sukses mengambil data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function getResourceByClassId(string $class_id)
    {
        try {
            $resource = $this->resource->getResourceByClassId($class_id);
            return ResponseHelper::success($resource, "Sukses mengambil data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function getAssignmentsCalendar()
    {
        try {
            $resource = $this->resource->getUserAssignments(auth()->user()->id);
            return ResponseHelper::success($resource, "Sukses mengambil data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }

    public function getAnswersByResource(mixed $id)
    {
        try {
            $resource = $this->resource->getAnswersByResource($id);
            return ResponseHelper::success($resource, "Sukses mengambil data!");
        } catch (\Exception $e) {
            return ResponseHelper::error(null, $e->getMessage());
        }
    }
}

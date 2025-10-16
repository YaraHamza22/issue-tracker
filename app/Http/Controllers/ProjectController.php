<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->getAll());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->getById($id));
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->service->create($request->validated());
        return response()->json(['message' => 'تم إنشاء المشروع بنجاح', 'data' => $project], 201);
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $project = $this->service->update($project, $request->validated());
        return response()->json(['message' => 'تم تحديث المشروع بنجاح', 'data' => $project]);
    }

    public function destroy(Project $project): JsonResponse
    {
        $this->service->delete($project);
        return response()->json(['message' => 'تم حذف المشروع بنجاح']);
    }
}

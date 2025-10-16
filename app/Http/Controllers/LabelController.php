<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use App\Models\Label;
use App\Services\LabelService;
use Illuminate\Http\JsonResponse;

class LabelController extends Controller
{
    public function __construct(protected LabelService $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->getAll());
    }

    public function store(StoreLabelRequest $request): JsonResponse
    {
        $label = $this->service->create($request->validated());
        return response()->json(['message' => 'تم إنشاء الوسم بنجاح', 'data' => $label], 201);
    }

    public function update(UpdateLabelRequest $request, Label $label): JsonResponse
    {
        $label = $this->service->update($label, $request->validated());
        return response()->json(['message' => 'تم تحديث الوسم بنجاح', 'data' => $label]);
    }

    public function destroy(Label $label): JsonResponse
    {
        $this->service->delete($label);
        return response()->json(['message' => 'تم حذف الوسم بنجاح']);
    }
}

<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function __construct(protected CommentService $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->getAll());
    }

    public function store(StoreCommentRequest $request): JsonResponse
    {
        $comment = $this->service->create($request->validated());
        return response()->json(['message' => 'تم إضافة التعليق بنجاح', 'data' => $comment], 201);
    }

    public function update(UpdateCommentRequest $request, Comment $comment): JsonResponse
    {
        $comment = $this->service->update($comment, $request->validated());
        return response()->json(['message' => 'تم تعديل التعليق بنجاح', 'data' => $comment]);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $this->service->delete($comment);
        return response()->json(['message' => 'تم حذف التعليق بنجاح']);
    }
}

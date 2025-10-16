<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(protected UserService $service) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->getAll());
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = $this->service->create($request->validated());
        return response()->json(['message' => 'تم إنشاء المستخدم بنجاح', 'data' => $user], 201);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $user = $this->service->update($user, $request->validated());
        return response()->json(['message' => 'تم تعديل المستخدم بنجاح', 'data' => $user]);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->service->delete($user);
        return response()->json(['message' => 'تم حذف المستخدم بنجاح']);
    }
}

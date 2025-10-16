<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use App\Models\Issue;
use App\Services\IssueService;
use Illuminate\Http\JsonResponse;

class IssueController extends Controller
{
    public function __construct(protected IssueService  $service) {

    }

    public function index(): JsonResponse
    {
        return response()->json($this->service->getAll());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->getById($id));
    }

    public function store(StoreIssueRequest $request): JsonResponse
    {
        $issue = $this->service->create($request->validated());
        return response()->json(['message' => 'تم إنشاء المشكلة بنجاح', 'data' => $issue], 201);
    }

    public function update(UpdateIssueRequest $request, Issue $issue): JsonResponse
    {
        $issue = $this->service->update($issue, $request->validated());
        return response()->json(['message' => 'تم تحديث المشكلة بنجاح', 'data' => $issue]);
    }

    public function destroy(Issue $issue): JsonResponse
    {
        $this->service->delete($issue);
        return response()->json(['message' => 'تم حذف المشكلة بنجاح']);
    }

    public function projectStats()
{
    return $this->successResponse('إحصائية القضايا لكل مشروع', $this->service->getProjectIssueStats());
}

public function userStats()
{
    return $this->successResponse('إحصائية القضايا لكل مستخدم', $this->service->getUserIssueStats());
}

public function issuesWithComments()
{
    return $this->successResponse('عدد التعليقات لكل قضية', $this->service->getIssuesWithCommentCount());
}

public function highPriority()
{
    return $this->successResponse('القضايا العاجلة والأكثر أهمية', $this->service->getHighPriorityIssues());
}

public function recentlyClosed(): JsonResponse
    {
        $recent = $this->service->getRecentlyClosedIssues();
        return $this->successResponse('القضايا المغلقة في سبعة ايام');
}
}

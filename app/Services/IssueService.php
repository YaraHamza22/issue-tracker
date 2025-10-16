<?php
namespace App\Services;

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IssueService
{
    public function getAll()
    {
        return Issue::with(['project','assignees','labels'])
            ->withCount('comments')
            ->latest()
            ->get();
    }

    public function getById(int $id)
    {
        return Issue::with(['project','assignees','labels','comments.user'])
            ->withCount('comments')
            ->findOrFail($id);
    }

    public function create(array $data): Issue
    {
        return DB::transaction(function () use ($data) {
            $issue = Issue::create($data);
            if (!empty($data['assignees'])) $issue->assignees()->sync($data['assignees']);
            if (!empty($data['labels'])) $issue->labels()->sync($data['labels']);
            return $issue->load(['assignees','labels']);
        });
    }

    public function update(Issue $issue, array $data): Issue
    {
        return DB::transaction(function () use ($issue, $data) {
            $issue->update($data);
            if (isset($data['assignees'])) $issue->assignees()->sync($data['assignees']);
            if (isset($data['labels'])) $issue->labels()->sync($data['labels']);
            return $issue->load(['assignees','labels']);
        });
    }

    public function delete(Issue $issue): void
    {
        DB::transaction(fn() => $issue->delete());
    }
      public function getProjectIssueStats()
    {
        return Project::withCount([
            'issues as open_issues_count' => fn($q) => $q->where('status', 'open'),
            'issues as closed_issues_count' => fn($q) => $q->where('status', 'closed'),
        ])->get(['id', 'name']);
    }

    public function getUserIssueStats()
    {
        return User::withCount([
            'assignedIssues as open_issues_count' => fn($q) => $q->where('status', 'open'),
            'assignedIssues as closed_issues_count' => fn($q) => $q->where('status', 'closed'),
        ])->get(['id', 'name', 'email']);
    }
    public function getIssuesWithCommentCount()
    {
        return Issue::with(['project','assignees','labels'])
            ->withCount('comments')
            ->orderByDesc('comments_count')
            ->get(['id', 'title', 'status', 'priority']);
    }


    public function getHighPriorityIssues()
    {
        return Issue::where('priority', 'urgent')
            ->whereRelation('project', 'name', 'like', '%Dashboard%')
            ->withCount('comments')
            ->get(['id', 'title', 'priority', 'status']);
    }
    public function getRecentlyClosedIssues()
{
    return Issue::where('status', 'closed')
        ->whereDate('updated_at', '>=', Carbon::now()->subDays(7))
        ->with(['project','assignees'])
        ->withCount('comments')
        ->orderByDesc('updated_at')
        ->get(['id','title','status','priority','updated_at']);
}

}

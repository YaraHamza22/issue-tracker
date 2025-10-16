<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    public function getAll()
    {
        return Project::withCount('issues')->latest()->get();
    }

    public function getById(int $id)
    {
        return Project::with('issues')->findOrFail($id);
    }

    public function create(array $data): Project
    {
        return DB::transaction(fn() => Project::create($data));
    }

    public function update(Project $project, array $data): Project
    {
        DB::transaction(fn() => $project->update($data));
        return $project->fresh();
    }

    public function delete(Project $project): void
    {
        DB::transaction(fn() => $project->delete());
    }
}

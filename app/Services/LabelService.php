<?php

namespace App\Services;

use App\Models\Label;
use Illuminate\Support\Facades\DB;

class LabelService
{
    public function getAll()
    {
        return Label::withCount('issues')->get();
    }

    public function create(array $data): Label
    {
        return DB::transaction(fn() => Label::create($data));
    }

    public function update(Label $label, array $data): Label
    {
        DB::transaction(fn() => $label->update($data));
        return $label->fresh();
    }

    public function delete(Label $label): void
    {
        DB::transaction(fn() => $label->delete());
    }
}

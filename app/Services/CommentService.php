<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommentService
{
    public function getAll()
    {
        return Comment::with(['user:id,name','issue:id,code'])->latest()->get();
    }

    public function create(array $data): Comment
    {
        return DB::transaction(fn() => Comment::create($data));
    }

    public function update(Comment $comment, array $data): Comment
    {
        DB::transaction(fn() => $comment->update($data));
        return $comment->fresh();
    }

    public function delete(Comment $comment): void
    {
        DB::transaction(fn() => $comment->delete());
    }

}

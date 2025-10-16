<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable=[
        'issue_id',
        'user_id',
        'content'
    ];
    public function issue():BelongsTo
    {
         return $this->belongsTo(Issue::class);
    }
     public function user():BelongsTo
    {
         return $this->belongsTo(User::class);
    }


}

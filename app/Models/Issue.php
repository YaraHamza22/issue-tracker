<?php

namespace App\Models;

use App\Casts\DueWindowCast;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    use HasFactory;

  protected $fillable=[
  'project_id',
  'code',
  'title',
   'body',
   'status',
   'priority',
   'due_window'
  ];

  protected $casts=[
    'due_window' =>DueWindowCast::class,
  ];

  public function project():BelongsTo{
    return $this->belongsTo(Project::class);
  }
  public function comments():HasMany{
    return $this->hasMany(Comment::class);
  }
  public function label():BelongsToMany{
    return $this->belongsToMany(label::class);
  }
  public function assignees():BelongsToMany{
    return $this->belongsToMany(User::class);
  }

  public function getStatusLabelAttribute():string{
    return match ($this->status){
        'open' => 'حالة مفتوحة',
        'in_progress'=> 'قيد التنفيذ',
        'closed' => 'حالة مغلقة',
        default =>ucfirst($this->status),

    };
}

public function setTitleAttribute($value):void{
    $this->attributes['title'] = trim($value);
}


public function scopeOpen($query)
{
    return $query->where('status', 'open');
}

public function scopeClosed($query)
{
    return $query->where('status', 'closed');
}

public function scopeUrgent($query)
{
    return $query->where('priority', 'urgent');
}

}

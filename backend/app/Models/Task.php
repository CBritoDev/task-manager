<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date'
    ];

    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeOverdue(Builder $query):Builder
    {
        return $query->where('due_date', '<',now())
        ->whereNot('status','done');
    }
}

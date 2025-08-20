<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Task extends Model
{
    use SoftDeletes, HasUlid, Searchable,HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'order',
        'user_id'
    ];

    // protected $casts = [
    //     'status' => TaskStatus::class,
    //     'priority' => TaskPriority::class,
    // ];

    public function searchableAs(): string
    {
        return 'tasks';
    }

    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'status' => (int)$this->status,
            'priority' => (int)$this->priority,
        ];
    }

    protected static function booted()
    {
        static::creating(function (Task $task) {
            if (is_string($task->status)) {
                $task->status = TaskStatus::from($task->status);
            }

            if (is_string($task->priority)) {
                $task->priority = TaskPriority::from($task->priority);
            }
        });

        static::updating(function (Task $task) {
            if (is_string($task->status)) {
                $task->status = TaskStatus::from($task->status);
            }

            if (is_string($task->priority)) {
                $task->priority = TaskPriority::from($task->priority);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

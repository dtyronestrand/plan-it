<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Calendar;

class Task extends Model
{
 protected $fillable = [
        'name',
        'user_id',
        'calendar_id',
        'notes',
        'done',
        'due_date',
    ];

    /**
     * Get the user that owns the task.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the calendar that the task belongs to.
     */
    public function calendar(): BelongsTo
    {
        return $this->belongsTo(Calendar::class);
    }

    public function subTasks(): HasMany
    {
        return $this->hasMany(SubTask::class);
    }
    
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }
}

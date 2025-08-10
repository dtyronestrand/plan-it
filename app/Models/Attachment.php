<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attachment extends Model
{
    protected $fillable = [
        'file_path',
        'file_name',
        'mime_type',
        'task_id', // Assuming this is the foreign key to the Task model
    ];

    /**
     * Get the task that owns the attachment.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}

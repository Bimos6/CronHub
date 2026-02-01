<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Execution extends Model
{
    use AsSource, Filterable;

    protected $fillable = [
        'job_id',
        'status_code',
        'response_body',
        'response_headers',
        'error_message',
        'duration_ms',
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'response_headers' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'duration_ms' => 'integer',
        'status_code' => 'integer',   
    ];

    protected $allowedSorts = [
        'job_id',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }
}

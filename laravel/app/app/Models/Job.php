<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Job extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'url',
        'cron_expression',  
        'method',
        'payload',
        'headers',        
        'is_active',        
        'last_run_at',     
        'next_run_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'headers' => 'array',           
        'is_active' => 'boolean',
        'last_run_at' => 'datetime',   
        'next_run_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function execution(): HasMany
    {
        return $this->hasMany(Execution::class)->latest('started_at');
    }
}

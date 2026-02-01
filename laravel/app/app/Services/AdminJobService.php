<?php

namespace App\Services;

use App\Models\Job;

class AdminJobService
{
    public function save(Job $job, array $data): Job
    {
        $job->fill($data);
        $job->save();
        return $job;
    }
    
    public function delete(Job $job): bool
    {
        return $job->delete();
    }
}
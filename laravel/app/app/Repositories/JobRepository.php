<?php

namespace App\Repositories;

use App\Models\Job;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\IJobRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class JobRepository implements IJobRepository
{
    public function create(array $data): Job
    {
        return Job::create($data);
    }

    public function all(Job $jobs): LengthAwarePaginator
    {
        
        return Job::query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

    }

    public function find(int $id): ?Job
    {
        return Job::find($id);
    }

    public function update(Job $job, array $data): bool
    {
        return $job->update($data);
    }

    public function delete(Job $job): bool 
    {
        return $job->delete();
    }

    public function getDueJobs(int $limit = 100): Collection
    {
        return Job::where('is_active', true)
            ->where('next_run_at', '<=', now())
            ->limit($limit)
            ->get();
    }

    public function findForUser(int $id, int $userId): ?Job 
    {
        return Job::where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    public function getStats(int $userId): array
    {
        return [
            'total' => Job::where('user_id', $userId)->count(),
            'active' => Job::where('user_id', $userId)
                ->where('is_active', true)->count(),
        ];
    }
}
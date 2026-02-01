<?php

namespace App\Repositories\Contracts;

use App\Models\Job;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IJobRepository
{
    public function create(array $data): Job;
    public function all(Job $jobs): LengthAwarePaginator;
    public function find(int $id): ?Job;
    public function update(Job $job, array $data): bool;
    public function delete(Job $job): bool; 
    
    public function getDueJobs(int $limit = 100): Collection;
    public function findForUser(int $id, int $userId): ?Job;
    public function allJobsForUser(int $userId, int $perPage = 20): LengthAwarePaginator;
    public function getStats(int $userId): array;
}
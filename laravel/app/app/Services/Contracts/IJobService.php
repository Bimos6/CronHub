<?php

namespace App\Services\Contracts;

use App\Models\Job;

interface IJobService
{
    public function createJob(array $data, int $userId): array;
    public function getUserJobs(int $userId): array;
    public function getUserJob(int $jobId, int $userId): array;
    public function getJob(int $jobId);
    public function updateJob(int $jobId, int $userId, array $data): array;
    public function deleteJob(int $jobId): array;
    
    public function getDueJobs(string $token): array;
}
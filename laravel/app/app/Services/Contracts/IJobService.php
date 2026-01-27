<?php

namespace App\Services\Contracts;

interface IJobService
{
    public function createJob(array $data, int $userId): array;
    public function getUserJobs(int $userId): array;
    public function getUserJob(int $jobId, int $userId): array;
    public function updateJob(int $jobId, int $userId, array $data): array;
    public function deleteJob(int $jobId, int $userId): array;
    
    public function getDueJobs(string $token): array;
    public function saveExecution(int $jobId, array $data, string $token): array;
    public function getExecutions(int $jobId, int $userId): array;
}
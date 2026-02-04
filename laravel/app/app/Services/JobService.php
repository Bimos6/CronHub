<?php

namespace App\Services;

use App\Models\Execution;
use App\Repositories\Contracts\IJobRepository;
use App\Services\Contracts\IJobService;
use App\Services\Contracts\ICronService;

class JobService implements IJobService
{
    public function __construct(
        private IJobRepository $repository,
        private ICronService $cronService
    ) {}
    
    public function createJob(array $data, int $userId): array
    {
        $nextRunAt = $this->cronService->getNextRunDate($data['cron_expression']);
        
        $job = $this->repository->create([
            ...$data,
            'user_id' => $userId,
            'next_run_at' => $nextRunAt,
        ]);
        
        return ['job' => $job];
    }
    
    public function getUserJobs(int $userId): array
    {
        $jobs = $this->repository->allJobsForUser($userId);
        
        return [
            'jobs' => $jobs,
        ];
    }
    
    public function getUserJob(int $jobId, int $userId): array
    {
        $job = $this->repository->findForUser($jobId, $userId);
        return ['job' => $job];
    }
    
    public function getJob(int $jobId)
    {
        $job = $this->repository->find($jobId);
        return $job;
    }

    public function updateJob(int $jobId, int $userId, array $data): array
    {
        $job = $this->repository->findForUser($jobId, $userId);
        
        if (isset($data['cron_expression'])) {
            $data['next_run_at'] = $this->cronService->getNextRunDate($data['cron_expression']);
        }
        
        $this->repository->update($job, $data);
        
        return ['job' => $job->fresh()];
    }
    
    public function deleteJob(int $jobId): array
    {
        $job = $this->repository->find($jobId);
        $this->repository->delete($job);
        
        return ['deleted' => true];
    }
    
    public function getDueJobs(string $token): array
    {
        if ($token !== config('app.scheduler_token')) {
            return ['error' => 'Unauthorized'];
        }
        
        $jobs = $this->repository->getDueJobs();
        
        foreach ($jobs as $job) {
            $nextRunAt = $this->cronService->getNextRunDate($job->cron_expression);
            
            $this->repository->update($job, [
                'next_run_at' => $nextRunAt,
                'last_run_at' => now(),
            ]);
        }
        
        return ['jobs' => $jobs];
    }
}
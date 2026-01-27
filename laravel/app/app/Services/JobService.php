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
        $paginator = $this->repository->all(new \App\Models\Job());
        $stats = $this->repository->getStats($userId);
        
        return [
            'jobs' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
            'stats' => $stats
        ];
    }
    
    public function getUserJob(int $jobId, int $userId): array
    {
        $job = $this->repository->findForUser($jobId, $userId);
        return ['job' => $job];
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
    
    public function deleteJob(int $jobId, int $userId): array
    {
        $job = $this->repository->findForUser($jobId, $userId);
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
    
    public function saveExecution(int $jobId, array $data, string $token): array
    {
        if ($token !== config('app.worker_token')) {
            return ['error' => 'Unauthorized'];
        }
        
        $job = $this->repository->find($jobId);
        
        $execution = Execution::create([
            'job_id' => $jobId,
            'status_code' => $data['status_code'],
            'response_body' => $data['response_body'] ?? null,
            'response_headers' => $data['response_headers'] ?? null,
            'error_message' => $data['error_message'] ?? null,
            'duration_ms' => $data['duration_ms'],
            'started_at' => $data['started_at'],
            'finished_at' => $data['finished_at'] ?? now(),
        ]);
        
        return ['execution' => $execution];
    }
    
    public function getExecutions(int $jobId, int $userId): array
    {
        $job = $this->repository->findForUser($jobId, $userId);
        $executions = $job->executions()->paginate(20);
        
        return ['executions' => $executions];
    }
}
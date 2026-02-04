<?php

namespace App\Services;

use App\Models\Execution;
use App\Repositories\Contracts\IExecutionRepository;
use App\Repositories\Contracts\IJobRepository;
use App\Services\Contracts\IExecutionService;
use Illuminate\Support\Collection;

class ExecutionService implements IExecutionService
{
    public function __construct(
        private IExecutionRepository $executionRepository
    ) {}
    
    public function createExecution(array $data): array
    {
        $execution = $this->executionRepository->create($data);
        return ['execution' => $execution];
    }

    public function saveExecution(array $data, string $token)
    {
        if ($token !== config('app.worker_token')) {
            return ['error' => 'Unauthorized'];
        }
        
        $execution = $this->executionRepository->create($data);
    }
    
    public function getAllExecutions(int $userId): array
    {
        $executions = $this->executionRepository->paginate($userId);
        
        return [
            'executions' => $executions,
        ];
    }

    public function getAllExecutionsForChart(int $userId): Collection
    {
        $userId = auth()->id();
        return $this->executionRepository->getByUserId($userId);
    }
}
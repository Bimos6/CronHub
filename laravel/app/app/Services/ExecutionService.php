<?php

namespace App\Services;

use App\Repositories\Contracts\IExecutionRepository;
use App\Repositories\Contracts\IJobRepository;
use App\Services\Contracts\IExecutionService;

class ExecutionService implements IExecutionService
{
    public function __construct(
        private IExecutionRepository $executionRepository
    ) {}
    
    public function saveExecution(array $data, string $token)
    {
        if ($token !== config('app.worker_token')) {
            return ['error' => 'Unauthorized'];
        }
        
        $execution = $this->executionRepository->create($data);
    }
    
    public function getAllExecutions(): array
    {
        $executions = $this->executionRepository->paginate();
        
        return [
            'executions' => $executions,
        ];
    }
}
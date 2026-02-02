<?php

namespace App\Orchid\Screens;

use App\Models\Execution;
use App\Services\Contracts\IExecutionService;
use Orchid\Screen\Screen;
use App\Orchid\Layouts\ExecutionListLayout;

class ExecutionScreen extends Screen
{
    public $name = 'История выполнений';

    public function __construct(private IExecutionService $executionService){  }

    public function query(): array
    {
        $userId = auth()->id();
        $data = $this->executionService->getAllExecutions($userId);

        return [
            'executions' => $data['executions'],
        ];
    }

    public function layout(): array
    {
        return [
            ExecutionListLayout::class,
        ];
    }
}

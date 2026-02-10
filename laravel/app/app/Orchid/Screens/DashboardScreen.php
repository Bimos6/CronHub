<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\DynamicsOfExecutions;
use App\Orchid\Layouts\DynamicsOfErrors;
use Orchid\Screen\Screen;
use App\Models\Execution;
use App\Services\Contracts\IExecutionService;
use App\Services\Contracts\IDashboardService;
use Orchid\Support\Facades\Layout;

class DashboardScreen extends Screen
{
    public $name = 'Дашборд';
    public $description = 'График выполнения крон задач';

    public function __construct(
        private IExecutionService $executionService,
        private IDashboardService $dashboardService
        ){}

    public function query(): array
    {
        $labels = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        
        $userId = auth()->id();
        $executions = $this->executionService->getAllExecutionsForChart($userId);
        
        $values = $this->dashboardService->executionsStatsValues($executions);
        $errorValues = $this->dashboardService->executionsErrorsStatsValues($executions);


        return [
            'executions' => [
                [
                    'labels' => $labels,
                    'name' => 'Выполнения задач за неделю',
                    'values' => $values,
                ]
            ],
            'errors' => [
                [
                    'labels' => $labels,
                    'name' => 'Задач с ошибкой',
                    'values' => $errorValues,
                ]
            ],
        ];
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [     
            DynamicsOfExecutions::class,
            DynamicsOfErrors::class,           
        ];
    }
}

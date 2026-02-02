<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\DynamicsOfExecutions;
use App\Orchid\Layouts\DynamicsOfErrors;
use Orchid\Screen\Screen;
use App\Models\Execution;
use App\Services\Contracts\IExecutionService;
use Orchid\Support\Facades\Layout;

class DashboardScreen extends Screen
{
    public $name = 'Дашборд';
    public $description = 'График выполнения крон задач';

    public function __construct(private IExecutionService $executionService){}

    public function query(): array
    {
        $labels = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        $values = [0, 0, 0, 0, 0, 0, 0];
        $errorValues = [0, 0, 0, 0, 0, 0, 0];
        
        $userId = auth()->id();
        $executions = $this->executionService->getAllExecutionsForChart($userId);
        
        foreach ($executions as $execution) {
            if ($execution->started_at) {
                $dayOfWeek = date('w', strtotime($execution->started_at));
                $index = $dayOfWeek - 1;
                if ($index < 0) $index = 6;
                $values[$index]++;
            }
        }

        foreach ($executions as $execution) {
            if ($execution->started_at && 
                ($execution->status_code !== 200 || !empty($execution->error_message))) {
                
                $dayOfWeek = date('w', strtotime($execution->started_at));
                $index = $dayOfWeek - 1;
                if ($index < 0) $index = 6;
                $errorValues[$index]++;
            }
        }

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

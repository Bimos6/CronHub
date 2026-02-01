<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\DynamicsOfExecutions;
use Orchid\Screen\Screen;
use App\Models\Execution;
use App\Models\Job;
use Orchid\Support\Facades\Layout;

class DashboardScreen extends Screen
{
    public $name = 'Дашборд';
    public $description = 'График выполнения крон задач';

    /* 
    TODO: разобраться в скрипте, доработать график:
        -Добавить вторую линию которая будет отображать количество задач с ошибкой
        -Добавить три окна: всего выполненных задач, выполненные успешно, выполненные с ошибкой)
        -В скрипте идёт запрос к бд - это плохая архитектура, нужен репозиторий
    */
    public function query(): array
    {
        $labels = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        $values = [0, 0, 0, 0, 0, 0, 0];
        
        $executions = Execution::all();
        
        foreach ($executions as $execution) {
            if ($execution->started_at) {
                $dayOfWeek = date('w', strtotime($execution->started_at));
                
                $index = $dayOfWeek - 1;
                if ($index < 0) $index = 6; 
                
                $values[$index]++;
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
        ];
    }
}

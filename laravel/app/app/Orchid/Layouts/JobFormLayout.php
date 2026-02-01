<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Rows;

class JobFormLayout extends Rows
{
    protected $target = 'job';

    protected function fields(): array
    {
        return [
            Input::make('job.name')
                ->title('Название задачи')
                ->placeholder('Например: Проверка API')
                ->required()
                ->help('Краткое описание задачи'),
            
            Input::make('job.url')
                ->title('URL')
                ->placeholder('https://example.com/api/health')
                ->required()
                ->help('Полный URL для запроса'),
            
            Select::make('job.method')
                ->title('HTTP Метод')
                ->options([
                    'GET' => 'GET',
                    'POST' => 'POST', 
                    'PUT' => 'PUT',
                    'DELETE' => 'DELETE',
                    'PATCH' => 'PATCH',
                ])
                ->value('GET')
                ->help('Метод HTTP запроса'),
            
            Input::make('job.cron_expression')
                ->title('Cron выражение')
                ->placeholder('* * * * *')
                ->required()
                ->help('Расписание выполнения. Пример: */5 * * * * - каждые 5 минут'),
            
            TextArea::make('job.headers')
                ->title('Заголовки (JSON)')
                ->rows(3)
                ->placeholder('{"Authorization": "Bearer token", "Content-Type": "application/json"}')
                ->help('HTTP заголовки в формате JSON'),
            
            TextArea::make('job.payload')
                ->title('Данные (JSON)')
                ->rows(3)
                ->placeholder('{"key": "value"}')
                ->help('Тело запроса для POST/PUT методов'),
            
            CheckBox::make('job.is_active')
                ->title('Активна')
                ->value(1)
                ->sendTrueOrFalse()
                ->help('Включить/выключить задачу'),
        ];
    }
}
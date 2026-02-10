<?php

namespace App\Orchid\Layouts;

use App\Models\Job;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;

class JobListLayout extends Table
{
    protected $target = 'jobs';

    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->width('100')
                ->sort()
                ->align('center'),
            
            TD::make('name', 'Название')
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make('url', 'URL')
                ->width('300')
                ->render(function (Job $job) {
                    return "<a href='{$job->url}' target='_blank' class='text-truncate d-block' style='max-width: 300px'>{$job->url}</a>";
                }),
                            
            TD::make('cron_expression', 'Расписание')
                ->width('150')
                ->align('center'),
                
            TD::make('is_active', 'Статус')
                ->width('100')
                ->render(function (Job $job) {
                    return $job->is_active 
                        ? "<span class='badge bg-success'>✅ Активна</span>"
                        : "<span class='badge bg-danger'>❌ Неактивна</span>";
                }),
                
            TD::make('next_run_at', 'След. запуск')
                ->width('150')
                ->sort()
                ->render(function (Job $job) {
                    return $job->next_run_at 
                        ? $job->next_run_at->format('d.m.Y H:i')
                        : '-';
                }),
            TD::make('Действия')
                ->width('150')
                ->align('center')
                ->render(function (Job $job) {
                    return Link::make('Редактировать')
                        ->icon('pencil')
                        ->route('platform.jobs.edit', $job->id)
                        ->class('btn btn-sm btn-primary');
                }),
        ];
    }
}
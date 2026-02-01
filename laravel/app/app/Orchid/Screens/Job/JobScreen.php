<?php

namespace App\Orchid\Screens\Job;

use App\Models\Job;
use App\Services\Contracts\IJobService;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use App\Orchid\Layouts\JobListLayout;

class JobScreen extends Screen
{
    public $name = 'Задачи';
    public $description = 'Список всех cron задач';

    public function __construct(private IJobService $jobService){}
    

    public function query(): array
    {
        $userId = auth()->id();
        
        $data = $this->jobService->getUserJobs($userId);

        return [
            'jobs' => $data['jobs'], 
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Создать задачу')
                ->icon('plus')
                ->route('platform.jobs.create'),
        ];
    }

    public function layout(): array
    {
        return [
            JobListLayout::class,
        ];
    }
}

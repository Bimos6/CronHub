<?php

namespace App\Orchid\Screens\Job;

use App\Models\Job;
use App\Services\Contracts\IJobService;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;
use App\Http\Requests\StoreJobRequest;
use App\Orchid\Layouts\JobFormLayout;

class JobCreateScreen extends Screen
{
    public $name = 'Создать задачу';
    public $description = 'Создание новой cron задачи';

    public function __construct(private IJobService $jobService){}

    public function query(Job $job): array
    {
        
        return ['job' => $job];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save'),
        ];
    }

    public function layout(): array
    {
        return [
            JobFormLayout::class,
        ];
    }

    public function save(StoreJobRequest $request)
    {
        $validated = $request->validated();
        
        $jobData = $validated['job'] ?? [];
        
        $userId = auth()->id();

        $this->jobService->createJob($jobData, $userId);
        
        Toast::success('Задача сохранена');
        return redirect()->route('platform.jobs');
    }

}

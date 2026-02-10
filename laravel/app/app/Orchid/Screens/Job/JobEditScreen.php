<?php

namespace App\Orchid\Screens\Job;

use App\Models\Job;
use App\Services\Contracts\IJobService;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;
use App\Orchid\Layouts\JobFormLayout;

class JobEditScreen extends Screen
{
    public $name = 'Редактировать задачу';
    public $description = 'Редактирование cron задачи';

    public function __construct(private IJobService $jobService){}

    public function query(Request $request): array
    {
        $jobId = $request->route('id');
        $job = $this->jobService->getJob($jobId);
        
        return [
            'job' => $job,
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('update'),
                
            Button::make('Удалить')
                ->icon('trash')
                ->method('delete')
                ->confirm('Удалить задачу?'),
        ];
    }

    public function layout(): array
    {
        return [
            JobFormLayout::class,
        ];
    }
    public function update(Request $request)
    {
        $jobId = $request->route('id');
        $job = $this->jobService->getJob($jobId);
        
        $job->fill($request->get('job'));
        $job->save();
        
        Toast::success('Задача обновлена');
        return redirect()->route('platform.jobs');
    }
    
    public function delete(Request $request)
    {
        $jobId = $request->route('id');
        $job = $this->jobService->getJob($jobId);
        $job->delete();
        
        Toast::info('Задача удалена');
        return redirect()->route('platform.jobs');
    }
}
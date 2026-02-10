<?php

namespace App\Orchid\Layouts;

use App\Models\Job;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Input;

class ExecutionListLayout extends Table
{
    protected $target = 'executions';

    public function columns(): array
    {
        return [
            TD::make('job_id', 'JobId')
                ->sort()
                ->align('center')
                ->width('100px'),
            
            TD::make('status_code', 'status_code')
                ->filter(Input::make())
                ->sort()
                ->align('center')
                ->width('100px'),
            
            TD::make('response_body', 'response_body')
                ->sort()
                ->filter(Input::make())
                ->align('center')
                ->width('100px'),
                            
            TD::make('response_headers', 'response_headers')
                ->sort()
                ->filter(Input::make())
                ->align('center')
                ->width('100px'),
                            
            TD::make('error_message', 'error_message')
                ->sort()
                ->filter(Input::make())
                ->align('center')
                ->width('100px'),
                            
            TD::make('duration_ms', 'duration_ms')
                ->sort()
                ->align('center')
                ->width('100px'),
                            
            TD::make('started_at', 'started_at')
                ->sort()
                ->align('center')
                ->width('100px'),

            TD::make('finished_at', 'finished_at')
                ->sort()
                ->align('center')
                ->width('100px'),
        ]; 
    }
}
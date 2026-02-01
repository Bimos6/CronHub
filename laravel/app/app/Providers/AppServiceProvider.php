<?php

namespace App\Providers;

use App\Repositories\JobRepository;
use App\Repositories\Contracts\IJobRepository;
use App\Services\JobService;
use App\Services\Contracts\IJobService;

use App\Repositories\ExecutionRepository;
use App\Repositories\Contracts\IExecutionRepository;
use App\Services\ExecutionService;
use App\Services\Contracts\IExecutionService;

use App\Services\CronService;
use App\Services\Contracts\ICronService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IJobService::class, JobService::class);
        $this->app->bind(IJobRepository::class, JobRepository::class);
        $this->app->bind(IExecutionService::class, ExecutionService::class);
        $this->app->bind(IExecutionRepository::class, ExecutionRepository::class);
        $this->app->bind(ICronService::class, CronService::class);
        $this->app->bind(ICronService::class, CronService::class);
    }
}

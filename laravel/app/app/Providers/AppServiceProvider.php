<?php

namespace App\Providers;

use App\Repositories\Contracts\IJobRepository;
use App\Repositories\JobRepository;
use App\Services\Contracts\ICronService;
use App\Services\Contracts\IJobService;
use App\Services\CronService;
use App\Services\JobService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IJobRepository::class, JobRepository::class);
        $this->app->bind(IJobService::class, JobService::class);
        $this->app->bind(ICronService::class, CronService::class);
    }
}

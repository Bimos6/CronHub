<?php

namespace App\Services;

use App\Services\Contracts\ICronService; 
use Cron\CronExpression;

class CronService implements ICronService 
{
    public function isValid(string $expression): bool
    {
        return CronExpression::isValidExpression($expression);
    }

    public function getNextRunDate(string $expression, string $timezone = 'UTC'): \DateTime
    {
        $cron = CronExpression::factory($expression);
        return $cron->getNextRunDate('now', 0, false, $timezone);
    }

    public function isDue(string $expression): bool
    {
        return CronExpression::factory($expression)->isDue();
    }

    public function getDescription(string $expression): string
    {
        $cron = CronExpression::factory($expression);
        return $cron->getExpression();
    }
}
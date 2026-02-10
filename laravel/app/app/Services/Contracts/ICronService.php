<?php

namespace App\Services\Contracts;

use Cron\CronExpression;

interface ICronService
{
    public function isValid(string $expression): bool;
    public function getNextRunDate(string $expression, string $timezone = 'UTC'): \DateTime;
    public function isDue(string $expression): bool;
    public function getDescription(string $expression): string;
}
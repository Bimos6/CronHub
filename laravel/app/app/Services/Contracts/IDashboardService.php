<?php

namespace App\Services\Contracts;

interface IDashboardService
{
    public function executionsStatsValues($executions): array;
    public function executionsErrorsStatsValues($executions): array;
}
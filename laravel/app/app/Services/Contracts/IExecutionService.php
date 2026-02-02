<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface IExecutionService
{
    public function saveExecution(array $data, string $token);
    public function getAllExecutions(int $userId): array;
    public function getAllExecutionsForChart(int $userId): Collection;
}
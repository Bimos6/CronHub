<?php

namespace App\Services\Contracts;


interface IExecutionService
{
    public function saveExecution(array $data, string $token);
    public function getAllExecutions(): array;
}
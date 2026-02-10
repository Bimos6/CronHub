<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Contracts\IExecutionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreExecutionRequest;

class ExecutionController extends Controller
{
    public function __construct(private IExecutionService $executionService) {}

    public function store(StoreExecutionRequest $request): JsonResponse
    {
        $result = $this->executionService->createExecution($request->validated());
        return response()->json($result, 201);
    }
}
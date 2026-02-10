<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Services\Contracts\IJobService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct(private IJobService $jobService) {}
    
    public function index(Request $request): JsonResponse
    {
        $result = $this->jobService->getUserJobs($request->user()->id);
        return response()->json($result);
    }
    
    public function store(StoreJobRequest $request): JsonResponse
    {
        $result = $this->jobService->createJob($request->validated(), $request->user()->id);
        return response()->json($result, 201);
    }
    
    public function show(Request $request, string $id): JsonResponse
    {
        $result = $this->jobService->getUserJob((int)$id, $request->user()->id);
        return response()->json($result);
    }
    
    public function update(StoreJobRequest $request, string $id): JsonResponse
    {
        $result = $this->jobService->updateJob((int)$id, $request->user()->id, $request->validated());
        return response()->json($result);
    }
    
    public function destroy(Request $request, string $id): JsonResponse
    {
        $result = $this->jobService->deleteJob((int)$id, $request->user()->id);
        return response()->json($result);
    }
    
    public function dueJobs(Request $request): JsonResponse
    {
        $result = $this->jobService->getDueJobs($request->header('X-Service-Key'));
        return response()->json($result);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Http\Requests\StoreJobRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $jobs = Job::query()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'data' => $jobs->items(),
            'meta' => [
                'current_page' => $jobs->currentPage(), 
                'last_page' => $jobs->lastPage(),        
                'per_page' => $jobs->perPage(),          
                'total' => $jobs->total(),                 
            ]
        ]);
    }

    public function store(StoreJobRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        
        $job = Job::create($validated);

        return response()->json([
            'message' => 'Job created successfully',
            'data' => $job
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $job = Job::findOrFail($id);

        return response()->json([
            'data' => $job
        ]);
    }

    public function update(StoreJobRequest $request, string $id)
    {
        $job = Job::findOrFail($id);

        $validated = $request->validated();

        $job->update($validated);

        return response()>json([
            'message' => 'Job updated successfully',
            'data' => $job
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $job = Job::findOrFail($id);

        $job->delete();

        return response()->json([
            'message' => 'Job deleted successfully'
        ]);
    }

    public function executions(Request $request, Job $job): JsonResponse
    {
        if($job->user_id !== $request->user()->id){
            abort(403, 'Unauthorized');
        }

        $executions = $job->executions()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'data' => $executions->items(),
            'meta' => [
                'current_page' => $executions->currentPage(),
                'last_page' => $executions->lastPage(),
                'per_page' => $executions->perPage(),
                'total' => $executions->total(),
            ]
        ]);
    }
}

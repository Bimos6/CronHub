<?php 

namespace App\Repositories;

use App\Models\Execution;
use App\Repositories\Contracts\IExecutionRepository;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ExecutionRepository implements IExecutionRepository
{
    public function create(array $data)
    {
        Execution::create($data);
    }
    
    public function all(): Collection
    {
        return Execution::all();
    }

    public function paginate(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return Execution::whereHas('job', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->paginate($perPage);
    }

    public function getByUserId(int $userId): Collection
    {
        return Execution::whereHas('job', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }

    public function getPaginatedByUserId(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return Execution::whereHas('job', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->paginate($perPage);
    }
}
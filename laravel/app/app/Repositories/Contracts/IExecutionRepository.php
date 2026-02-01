<?php 

namespace App\Repositories\Contracts;

use App\Models\Execution;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IExecutionRepository
{
    public function create(array $data);
    public function all(): Collection;
    public function paginate(int $perPage = 20): LengthAwarePaginator;
}
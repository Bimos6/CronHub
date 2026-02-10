<?php

namespace Tests\Unit;

use App\Services\Contracts\IDashboardService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExecutionStatsTest extends TestCase
{
    private IDashboardService $dashboardService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dashboardService = app(IDashboardService::class);
    }

    public function test_executions_stats_values()
    {
        $executions = collect([
            (object)['started_at' => '2023-10-08'],
            (object)['started_at' => '2023-10-09'],
            (object)['started_at' => null],
            (object)['started_at' => '2023-10-10'],
            (object)['started_at' => '2023-10-11'],
            (object)['started_at' => '2023-10-12'],
            (object)['started_at' => '2023-10-13'],
            (object)['started_at' => '2023-10-14'],
            (object)['started_at' => '2023-10-15'],
        ]);

        $result = $this->dashboardService->executionsStatsValues($executions);

        $expectedResult = [1, 1, 1, 1, 1, 1, 2];  
        
        $this->assertEquals($expectedResult, $result);
    }

    public function test_executions_error_stats_values()
    {
        $executions = collect([
        (object)[
            'started_at' => '2023-10-08',
            'status_code' => 200,
            'error_message' => null
        ],

        (object)[
            'started_at' => '2023-10-08',
            'status_code' => 301,
            'error_message' => null
        ],

        (object)[
            'started_at' => '2023-10-09',
            'status_code' => 404,
            'error_message' => null
        ],

        (object)[
            'started_at' => '2023-10-10',
            'status_code' => 200,
            'error_message' => 'Connection timeout'
        ],

        (object)[
            'started_at' => '2023-10-11',
            'status_code' => 500,
            'error_message' => 'Internal server error'
        ],

        (object)[
            'started_at' => '2023-10-12',
            'status_code' => 200,
            'error_message' => null
        ],

        (object)[
            'started_at' => null,
            'status_code' => 500,
            'error_message' => 'Error'
        ],

        (object)[
            'started_at' => '2023-10-14',
            'status_code' => 403,
            'error_message' => null
        ],

        (object)[
            'started_at' => '2023-10-15',
            'status_code' => 200,
            'error_message' => 'Timeout'
        ],
    ]);

        $result = $this->dashboardService->executionsErrorsStatsValues($executions);
        
        $expectedResult = [1, 1, 1, 0, 0, 1, 2];
        
        $this->assertEquals($expectedResult, $result);
    }
}
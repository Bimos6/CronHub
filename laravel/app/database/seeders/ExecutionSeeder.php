<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Job;
use \App\Models\Execution;

class ExecutionSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = Job::all();

        foreach ($jobs as $job) {
            $executionCount = rand(1, 5); 

            for ($i = 0; $i < $executionCount; $i++) {
                Execution::create([
                    'job_id'           => $job->id,
                    'status_code'      => 200, 
                    'response_body'    => json_encode(['message' => 'Sample response body']),
                    'response_headers' => json_encode(['Content-Type' => 'application/json']), 
                    'error_message'    => null, 
                    'duration_ms'      => rand(100, 1000), 
                    'started_at'       => now()->subSeconds(rand(10, 60))->toDateTimeString(), 
                    'finished_at'      => now()->toDateTimeString(), 
                ]);
            }
        }
    }
}

<?php

namespace Tests\Unit\Services;

use App\Models\Job;
use App\Models\User;
use App\Services\Contracts\IJobService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class JobServiceTest extends TestCase
{
    use DatabaseTransactions;

    private $jobService;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->jobService = app(IJobService::class);
    }

    public function test_create_job()
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Test Job',
            'url' => 'http://example.com',
            'cron_expression' => '* * * * *',
            'method' => 'GET'
        ];
        
        $result = $this->jobService->createJob($data, $user->id);
        
        $this->assertArrayHasKey('job', $result);
        $this->assertInstanceOf(Job::class, $result['job']);
        $this->assertEquals('Test Job', $result['job']->name);
        $this->assertEquals($user->id, $result['job']->user_id);
        $this->assertNotNull($result['job']->next_run_at);
    }

    public function test_get_user_jobs()
    {
        $user = User::factory()->create();
        Job::factory()->count(3)->create(['user_id' => $user->id]);
        Job::factory()->count(2)->create(); 
        
        $result = $this->jobService->getUserJobs($user->id);
        
        $this->assertArrayHasKey('jobs', $result);
        $this->assertCount(3, $result['jobs']);
        $this->assertEquals($user->id, $result['jobs']->first()->user_id);
    }

    public function test_get_user_job()
    {
        $user = User::factory()->create();
        $job = Job::factory()->create(['user_id' => $user->id]);
        
        $result = $this->jobService->getUserJob($job->id, $user->id);
        
        $this->assertArrayHasKey('job', $result);
        $this->assertEquals($job->id, $result['job']->id);
    }

    public function test_get_Job()
    {
        $job = Job::factory()->create();
        
        $result = $this->jobService->getJob($job->id);
        
        $this->assertEquals($job->id, $result->id);
    }

    // public function testUpdateJob()
    // {
    //     $job = Job::factory()->create(['name' => 'Old Name']);
        
    //     $result = $this->jobService->updateJob($job->id, ['name' => 'New Name']);
        
    //     $this->assertArrayHasKey('job', $result);
    //     $this->assertEquals('New Name', $result['job']->name);
    //     $this->assertNotEquals('Old Name', $result['job']->name);
    // }

    public function test_delete_job()
    {
        $job = Job::factory()->create();
        
        $result = $this->jobService->deleteJob($job->id);
        
        $this->assertArrayHasKey('deleted', $result);
        $this->assertTrue($result['deleted']);
        $this->assertNull(Job::find($job->id));
    }
}
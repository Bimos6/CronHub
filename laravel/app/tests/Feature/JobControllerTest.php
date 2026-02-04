<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class JobControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_user_can_create_job()
    {
        $response = $this->withToken($this->token)
            ->postJson('/api/v1/jobs', [
                'name' => 'Test Job',
                'url' => 'https://api.example.com/webhook',
                'cron_expression' => '* * * * *',
                'method' => 'GET',
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('jobs', ['name' => 'Test Job']);
    }

    public function test_user_can_get_jobs_list()
    {
        Job::factory()->count(2)->for($this->user)->create();

        $response = $this->withToken($this->token)
            ->getJson('/api/v1/jobs');

        $response->assertOk();
    }

    public function test_user_can_view_job()
    {
        $job = Job::factory()->for($this->user)->create();

        $response = $this->withToken($this->token)
            ->getJson("/api/v1/jobs/{$job->id}");

        $response->assertOk();
    }

    public function test_user_can_update_job()
    {
        $job = Job::factory()->for($this->user)->create();

        $response = $this->withToken($this->token)
            ->putJson("/api/v1/jobs/{$job->id}", [
                'name' => 'Updated Name',
                'url' => $job->url,
                'cron_expression' => $job->cron_expression,
                'method' => $job->method,
            ]);

        
        $response->assertOk();
        $this->assertDatabaseHas('jobs', ['name' => 'Updated Name']);
    }

    public function test_user_can_delete_job()
    {
        $job = Job::factory()->for($this->user)->create();

        $response = $this->withToken($this->token)
            ->deleteJson("/api/v1/jobs/{$job->id}");

        $response->assertOk();
        $response->assertJson(['deleted' => true]); 
        
        $this->assertDatabaseMissing('jobs', ['id' => $job->id]);
    }
}
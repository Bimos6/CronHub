<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use \App\Models\User;

class JobSeeder extends Seeder
{
    public function run(): void
    {   
        $user = User::whereEmail('admin@example.com')->first();

        Job::create([
            'user_id' => $user->id,
            'name' => 'Test Job',
            'url' => 'https://example.com/api/test',
            'cron_expression' => '* * * * *',
            'method' => 'POST',
            'payload' => ['key' => 'value'],
            'headers' => ['Content-Type' => 'application/json'],
            'is_active' => true,
            'last_run_at' => now(),
            'next_run_at' => now()->addMinutes(5),
        ]);
    }
}

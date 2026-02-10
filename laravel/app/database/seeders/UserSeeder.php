<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'], 
            [
                'name' => 'Administrator',
                'password' => Hash::make('qwerty'), 
                'email_verified_at' => now(),
                'permissions' => [
                    'platform.index' => true,
                    'platform.systems.roles' => true,
                    'platform.systems.users' => true,
                    'platform.systems.attachment' => true,
                ],
            ]
        );

        $user->update(['password' => Hash::make('qwerty')]);
    }
}
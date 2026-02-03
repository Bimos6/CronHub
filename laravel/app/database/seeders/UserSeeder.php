<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        if (!User::whereEmail('admin@example.com')->exists()) {
            User::factory()->admin()->create([
                'email' => 'admin@example.com',
                'name' => 'Administrator',   
                'password' => 'qwerty',     
            ]);
            
            echo "Администратор успешно создан.\n";
        } else {
            echo "Пользователь с email admin@example.com уже существует.\n";
        }
    }
}

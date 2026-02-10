<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class ValidCredentials implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $email = request()->input('email');

        if (!$email) {
            $fail('Email is required.');
            return;
        }
        
        $user = User::where('email', $email)->first();
        
        if (!$user || !Hash::check($value, $user->password)) {
            $fail('Invalid email or password.');
        }
    }
}
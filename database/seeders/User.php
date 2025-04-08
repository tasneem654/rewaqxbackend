<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Arwa',
            'email' => 'tawfiq1113@gmail.com',
            'otp' => null,
            'otp_expires_at' => null,
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Optional: add another user for testing
        User::create([
            'name' => 'Amal',
            'email' => 'arwa8517@gmail.com',
            'otp' => null,
            'otp_expires_at' => null,
            'password' => Hash::make('mysecurepassword'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}

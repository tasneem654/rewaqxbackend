<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
      
        $this->call(AdminSeeder::class);

    
        User::create([
            'id' => '1',
            'email' => 'tawfiq1113@gmail.com',
            'otp' => null,
            'otp_expiration' => null,
            'password' => Hash::make('password123'),
            'isManager' => 'false',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'id' => '2',
            'email' => 'arwa8517@gmail.com',
            'otp' => null,
            'otp_expiration' => null,
            'password' => Hash::make('mysecurepassword'),
            'isManager' => 'false',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}

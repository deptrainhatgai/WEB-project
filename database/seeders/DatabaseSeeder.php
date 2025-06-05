<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Thêm dòng này

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $existingUser = User::where('email', 'test@example.com')->first();

        if (!$existingUser) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Chạy ProductSeeder
        $this->call([
            ProductSeeder::class,
        ]);
    }
}

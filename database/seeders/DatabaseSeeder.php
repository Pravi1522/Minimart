<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Admin::create([
            'full_name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678', 
        ]);

        User::create([
            'first_name' => 'user',
            'last_name' => 'developer',
            'email' => 'user@gmail.com',
            'password' => '12345678', 
        ]);

        $this->call([
            ProductSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\category;
use App\Models\course;
use App\Models\User;
use App\Models\video;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        category::factory(5)->create();
        course::factory(20)->create();
        video::factory(100)->create();
    }
}

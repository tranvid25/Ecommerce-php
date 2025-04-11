<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for($i=1;$i<10;$i++){
            Post::query()->create([
                'title'=>fake()->text()
            ]);
        }
        for($i=1;$i<100;$i++){
            Comment::query()->create([
                'post_id'=>rand(1,9),
                'message'=>fake()->text()
            ]);
        }

    }
}

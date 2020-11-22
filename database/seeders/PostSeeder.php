<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    const POSTS_COUNT = 30;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()->count(static::POSTS_COUNT)->create();

        for ($i = 1; $i <= static::POSTS_COUNT; ++$i){
            DB::table('posts_of_categories')->insert([
                'post_id' => $i,
                'category_id' => Category::all()->random()->id,
            ]);
        }
    }
}

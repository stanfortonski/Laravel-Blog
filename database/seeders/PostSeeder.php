<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory()->count(30)->create()->each(function($post){
            DB::table('posts_of_categories')->insert([
                'post_id' => $post->id,
                'category_id' => Category::all()->random()->id,
            ]);

            $locales = config('blog.available_locales');
            $contentDefault = PostContent::factory()->create(['lang' => $locales[0]]);
            DB::table('contents_of_posts')->insert([
                'post_id' => $post->id,
                'content_id' => $contentDefault->id,
            ]);

            $contentSecond = PostContent::factory()->create(['lang' => $locales[1]]);
            DB::table('contents_of_posts')->insert([
                'post_id' => $post->id,
                'content_id' => $contentSecond->id,
            ]);
        });
    }
}

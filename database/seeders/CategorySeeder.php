<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Content;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(5)->create()->each(function($category){
            $locales = config('app.available_locales');
            $contentDefault = Content::factory()->create(['lang' => $locales[0]]);
            DB::table('contents_of_categories')->insert([
                'category_id' => $category->id,
                'content_id' => $contentDefault->id,
            ]);

            $contentSecond = Content::factory()->create(['lang' => $locales[1]]);
            DB::table('contents_of_categories')->insert([
                'category_id' => $category->id,
                'content_id' => $contentSecond->id,
            ]);
        });
    }
}

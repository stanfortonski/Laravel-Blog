<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get(route('categories.index', app()->getLocale()));

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $url = Category::all()->random()->content()->firstOrFail()->url;

        $response = $this->get(route('categories.show', [app()->getLocale(), $url]));

        $response->assertStatus(200);
    }
}

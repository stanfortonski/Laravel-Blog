<?php

namespace Tests\Feature\API;

use App\Models\Category;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->getJson(route('api.categories.index'));

        $response->assertOk();
    }

    public function testShow()
    {
        $id = Category::all()->random()->id;

        $response = $this->getJson(route('api.categories.show', $id));

        $response->assertOk();
    }
}

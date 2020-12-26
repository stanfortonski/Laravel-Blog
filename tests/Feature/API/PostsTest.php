<?php

namespace Tests\Feature\API;

use App\Models\Post;
use Tests\TestCase;

class PostsTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->getJson(route('api.posts.index'));

        $response->assertStatus(200);
    }

    public function testShow()
    {
        $id = Post::visible()->get()->random()->id;

        $response = $this->getJson(route('api.posts.show', $id));

        $response->assertStatus(200);
    }
}

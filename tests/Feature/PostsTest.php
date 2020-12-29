<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;

class PostsTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get(route('posts.index', app()->getLocale()));

        $response->assertOk();
    }

    public function testShow()
    {
        $url = Post::has('content')->visible()->get()->random()->content()->firstOrFail()->url;

        $response = $this->get(route('posts.show', [app()->getLocale(), $url]));

        $response->assertOk();
    }
}

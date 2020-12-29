<?php

namespace Tests\Unit;

use App\Models\Post;
use Tests\TestCase;

class PostTest extends TestCase
{
    private $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = Post::has('content')->visible()->get()->random();
    }

    public function testContent()
    {
        $content = $this->post->content()->first();
        $this->assertEquals($content->lang, app()->getLocale());

        $contentsCount = $this->post->contents()->count();
        $this->assertEquals(2, $contentsCount);
    }

    public function testSearch(){
        $notExists = 'ABCXYZ123';
        $content = $this->post->content()->first();

        $this->assertTrue(Post::search($content->title)->count() >= 1);
        $this->assertTrue(Post::search($content->description)->count() >= 1);
        $this->assertTrue(Post::search($notExists)->count() == 0);
    }
}

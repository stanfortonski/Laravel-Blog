<?php

namespace Tests\Feature\Admin;

use App\Models\PostContent;
use App\Models\Content;
use Tests\TestCase;

class ContentTest extends TestCase
{
    private $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->getAdmin();
    }

    public function testDestroyCategoryContent()
    {
        $content = Content::all()->random();
        $response = $this->actingAs($this->admin)->delete(route('admin.content.destroy', $content->id));

        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $emptyContent = Content::find($content->id);
        $this->assertEmpty($emptyContent);
    }

    public function testDestroyPostContent()
    {
        $content = PostContent::all()->random();
        $response = $this->actingAs($this->admin)->delete(route('admin.post-content.destroy', $content->id));

        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $emptyContent = PostContent::find($content->id);
        $this->assertEmpty($emptyContent);
    }
}

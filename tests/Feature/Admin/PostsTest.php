<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Content;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class PostsTest extends TestCase
{
    private $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->getAdmin();
        $this->post = Post::all()->random();
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.posts.index'));

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.posts.create'));

        $response->assertOk();
    }

    public function testEdit()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.posts.edit', $this->post->id));

        $response->assertOk();
    }

    public function testEditByAuthor()
    {
        $response = $this->actingAs($this->post->author)->get(route('admin.posts.edit', $this->post->id));

        $response->assertOk();
    }

    public function testEditByNotPrivileged()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.posts.edit', $this->post->id));

        $response->assertStatus(403);
    }

    public function testDestroy()
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.posts.destroy', $this->post->id));

        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $emptyPost = Post::find($this->post->id);
        $this->assertEmpty($emptyPost);
    }

    public function testDestroyByAuthor()
    {
        $response = $this->actingAs($this->post->author)->delete(route('admin.posts.destroy', $this->post->id));

        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $emptyPost = Post::find($this->post->id);
        $this->assertEmpty($emptyPost);
    }

    public function testDestroyByNotPrivileged()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.posts.destroy', $this->post->id));

        $response->assertStatus(403);

        $notEmptyPost = Post::find($this->post->id);
        $this->assertNotEmpty($notEmptyPost);
    }

    public function testStore()
    {
        $data = Post::factory()->make()->toArray();
        $data['_token'] = csrf_token();
        $data['content'] = Content::factory()->make()->toArray();
        $data['categories'] = [Category::all()->random()->id];

        if ($data['is_visible'] == 0)
            unset($data['is_visible']);

        $response = $this->actingAs($this->admin)->post(route('admin.posts.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $post = Post::orderBy('id', 'desc')->first();
        $this->assertEquals($data['author_id'], $this->admin->id, 'Author');
        $this->assertEquals($data['publish_at'], $post->publish_at, 'Publish At');
        $this->assertEquals($data['tags'], $post->tags, 'Tags');
        if (empty($data['is_visible']))
            $this->assertEquals(0, $post->is_visible, 'Visible');
        else $this->assertEquals($data['is_visible'], $post->is_visible, 'Visible');
        $this->assertEquals($data['content']['title'], $post->content()->first()->title, 'Title');
        $this->assertEquals($data['content']['content'], $post->content()->first()->content, 'Content');
        $this->assertEquals($data['content']['url'], $post->content()->first()->url, 'Url');
        $this->assertEquals($data['categories'], Arr::flatten($post->categories()->pluck('id')->values()->toArray()), 'Categories');
    }

    public function testUpdate()
    {
        $data = Post::factory()->make()->toArray();
        $data['_token'] = csrf_token();
        $data['content'] = Content::factory()->make()->toArray();
        $data['categories'] = [Category::all()->random()->id];

        if ($data['is_visible'] == 0)
            unset($data['is_visible']);

        $response = $this->actingAs($this->admin)->put(route('admin.posts.update', $this->post->id), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->post->refresh();
        $this->assertEquals($data['publish_at'], $this->post->publish_at, 'Publish At');
        $this->assertEquals($data['tags'], $this->post->tags, 'Tags');
        if (empty($data['is_visible']))
            $this->assertEquals(0, $this->post->is_visible, 'Visible');
        else $this->assertEquals($data['is_visible'], $this->post->is_visible, 'Visible');
        $this->assertEquals($data['content']['title'], $this->post->content()->first()->title, 'Title');
        $this->assertEquals($data['content']['content'], $this->post->content()->first()->content, 'Content');
        $this->assertEquals($data['content']['url'], $this->post->content()->first()->url, 'Url');
        $this->assertEquals($data['categories'], Arr::flatten($this->post->categories()->pluck('id')->values()->toArray()), 'Categories');
    }
}

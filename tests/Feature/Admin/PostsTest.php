<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Illuminate\Support\Str;

class PostsTest extends TestCase
{
    private $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->getAdmin();
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
        $post = Post::all()->random();

        $response = $this->actingAs($this->admin)->get(route('admin.posts.edit', $post->id));

        $response->assertOk();
    }

    public function testEditByAuthor()
    {
        $post = Post::all()->random();

        $response = $this->actingAs($post->author)->get(route('admin.posts.edit', $post->id));

        $response->assertOk();
    }

    public function testEditByNotPrivileged()
    {
        $post = Post::all()->random();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.posts.edit', $post->id));

        $response->assertStatus(403);
    }

    public function testDestroy()
    {
        $post = Post::all()->random();

        $response = $this->actingAs($this->admin)->delete(route('admin.posts.destroy', $post->id));

        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $emptyPost = Post::find($post->id);
        $this->assertEmpty($emptyPost);
    }

    public function testDestroyByAuthor()
    {
        $post = Post::all()->random();

        $response = $this->actingAs($post->author)->delete(route('admin.posts.destroy', $post->id));

        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $emptyPost = Post::find($post->id);
        $this->assertEmpty($emptyPost);
    }

    public function testDestroyByNotPrivileged()
    {
        $post = Post::all()->random();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.posts.destroy', $post->id));

        $response->assertStatus(403);

        $notEmptyPost = Post::find($post->id);
        $this->assertNotEmpty($notEmptyPost);
    }

    public function testStore()
    {
        $data = Post::factory()->make()->toArray();
        $data['_token'] = csrf_token();
        $data['content'] = [
            'title' => Str::random(10),
            'content' => Str::random(255)
        ];
        $data['categories'] = [Category::all()->random()->id];

        if ($data['is_visible'] == 0)
            unset($data['is_visible']);

        $response = $this->actingAs($this->admin)->post(route('admin.posts.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $post = Post::orderBy('id', 'desc')->first();
        $this->assertEquals($data['author_id'], $this->admin->id, 'Author');
        $this->assertEquals($data['publish_at'], $post->publish_at, 'Publish At');
        if ($data['is_visible'] == 0)
            $this->assertEquals(0, $post->is_visible, 'Visible');
        else $this->assertEquals($data['is_visible'], $post->is_visible, 'Visible');
        $this->assertEquals($data['content']['title'], $post->content()->first()->title, 'Title');
        $this->assertEquals($data['content']['content'], $post->content()->first()->content, 'Content');
        $this->assertEquals($data['categories'], Arr::flatten($post->categories()->pluck('id')->values()->toArray()), 'Categories');
    }

    public function testUpdate()
    {
        $post = Post::all()->random();
        $data = Post::factory()->make()->toArray();
        $data['_token'] = csrf_token();
        $data['content'] = [
            'title' => Str::random(10),
            'content' => Str::random(255)
        ];
        $data['categories'] = [Category::all()->random()->id];

        if ($data['is_visible'] == 0)
            unset($data['is_visible']);

        $response = $this->actingAs($this->admin)->put(route('admin.posts.update', $post->id), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $post->refresh();
        $this->assertEquals($data['publish_at'], $post->publish_at, 'Publish At');
        if ($data['is_visible'] == 0)
            $this->assertEquals(0, $post->is_visible, 'Visible');
        else $this->assertEquals($data['is_visible'], $post->is_visible, 'Visible');
        $this->assertEquals($data['content']['title'], $post->content()->first()->title, 'Title');
        $this->assertEquals($data['content']['content'], $post->content()->first()->content, 'Content');
        $this->assertEquals($data['categories'], Arr::flatten($post->categories()->pluck('id')->values()->toArray()), 'Categories');
    }
}

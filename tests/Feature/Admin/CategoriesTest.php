<?php

namespace Tests\Feature\Admin;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Support\Str;

class CategoriesTest extends TestCase
{
    private $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->getAdmin();
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.categories.index'));

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.categories.create'));

        $response->assertOk();
    }

    public function testEdit()
    {
        $category = Category::all()->random();

        $response = $this->actingAs($this->admin)->get(route('admin.categories.edit', $category->id));

        $response->assertOk();
    }

    public function testDestroy()
    {
        $category = Category::all()->random();

        $response = $this->actingAs($this->admin)->delete(route('admin.categories.destroy', $category->id));

        $response->assertSessionHas('success');
        $response->assertStatus(302);

        $emptyCategory = Category::find($category->id);
        $this->assertEmpty($emptyCategory);
    }

    public function testStore()
    {
        $data = Category::factory()->make()->toArray();
        $data['_token'] = csrf_token();
        $data['content'] = [
            'title' => Str::random(10),
            'content' => Str::random(255)
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $category = Category::orderBy('id', 'desc')->first();
        $this->assertEquals($data['content']['title'], $category->content()->first()->title, 'Title');
        $this->assertEquals($data['content']['content'], $category->content()->first()->content, 'Content');
    }

    public function testUpdate()
    {
        $category = Category::all()->random();
        $data = Category::factory()->make()->toArray();
        $data['_token'] = csrf_token();
        $data['content'] = [
            'title' => Str::random(10),
            'content' => Str::random(255)
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.categories.update', $category->id), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $category->refresh();
        $this->assertEquals($data['content']['title'], $category->content()->first()->title, 'Title');
        $this->assertEquals($data['content']['content'], $category->content()->first()->content, 'Content');
    }
}

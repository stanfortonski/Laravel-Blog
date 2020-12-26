<?php

namespace Tests\Unit;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    private $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = Category::all()->random();
    }

    public function testContent()
    {
        $content = $this->category->content()->first();
        $this->assertEquals($content->lang, app()->getLocale());

        $contentsCount = $this->category->contents()->count();
        $this->assertEquals(2, $contentsCount);
    }

    public function testSearch(){
        $notExists = 'ABCXYZ123';
        $content = $this->category->content()->first();

        $this->assertTrue(Category::search($content->title)->count() >= 1);
        $this->assertTrue(Category::search($content->description)->count() >= 1);
        $this->assertTrue(Category::search($notExists)->count() == 0);
    }
}

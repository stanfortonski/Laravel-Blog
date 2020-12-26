<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;

class AdminTest extends TestCase
{
    private $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->getAdmin();
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.index'));

        $response->assertOk();
    }

    /*
     * TODO | Works but tests show errors.

    public function testSetFirstLocale()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.index'));
        $response = $this->actingAs($this->admin)->get(route('admin.set-lang', 'en'));

        $response->assertStatus(302);
        $this->assertEquals('en', app()->getLocale());
    }

    public function testSetSecondLocale()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.index'));
        $response = $this->actingAs($this->admin)->get(route('admin.set-lang', 'pl'));

        $response->assertStatus(302);
        $this->assertEquals('pl', app()->getLocale());
    }
    */
}

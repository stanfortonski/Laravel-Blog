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
}

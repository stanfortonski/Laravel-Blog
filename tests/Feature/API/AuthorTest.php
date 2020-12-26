<?php

namespace Tests\Feature\API;

use App\Models\User;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    public function testShowAuthor()
    {
        $user = User::all()->random();

        $response = $this->getJson(route('api.author', $user->id));

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    public function testShowAuthor()
    {
        $user = User::all()->random();

        $response = $this->get(route('author', [app()->getLocale(), $user->url]));

        $response->assertOk();
    }
}

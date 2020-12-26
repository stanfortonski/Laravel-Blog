<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::all()->random();
    }

    public function testSearch(){
        $notExists = 'ABCXYZ123';

        $this->assertTrue(User::search($this->user->first_name)->count() >= 1);
        $this->assertTrue(User::search($this->user->last_name)->count() >= 1);
        $this->assertTrue(User::search($notExists)->count() == 0);
    }
}

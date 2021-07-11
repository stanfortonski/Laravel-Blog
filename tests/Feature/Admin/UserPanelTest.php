<?php

namespace Tests\Feature\Admin;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserPanelTest extends TestCase
{
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->getRandomUser();
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->user)->get(route('admin.user-panel.index'));

        $response->assertOk();
    }

    public function testChangePassword()
    {
        $password = Str::random(8);

        $response = $this->actingAs($this->user)->put(route('admin.user-panel.password'), [
            '_token' => csrf_token(),
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->user->refresh();
        $this->assertTrue(Hash::check($password, $this->user->password));
    }

    /**
     * @dataProvider langProvider
     */
    public function testUpdate($lang)
    {
        $data = User::factory()->make()->toArray();
        $data['_token'] = csrf_token();
        $data['content'] = Str::random(128);
        $data['lang'] = $lang;

        $response = $this->actingAs($this->user)->put(route('admin.user-panel.update'), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->user->refresh();
        $this->assertEquals($data['name'], $this->user->name, 'Name');
        $this->assertEquals($data['first_name'], $this->user->first_name, 'First Name');
        $this->assertEquals($data['last_name'], $this->user->last_name, 'Last Name');
        $this->assertEquals($data['email'], $this->user->email, 'Email');
        $this->assertEquals($data['website'], $this->user->website, 'Website');
        $this->assertEquals($data['content'], $this->user->content()->first()->content, 'Content');
        $this->assertEquals($data['lang'], $this->user->content()->first()->lang, 'Lang');
        $this->assertEquals($data['url'], Helper::properUrl($this->user->first_name.' '.$this->user->last_name), 'Url');
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;
use Stanfortonski\Laravelroles\Models\Role;

class UsersTest extends TestCase
{
    private $admin;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->getAdmin();
    }

    public function testIndex()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));

        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.create'));

        $response->assertOk();
    }

    public function testEdit()
    {
        $user = User::all()->random();

        $response = $this->actingAs($this->admin)->get(route('admin.users.edit', $user->id));

        $response->assertOk();
    }

    public function testDestroy()
    {
        $user = User::all()->random();

        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $user->id));

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $emptyUser = User::find($user->id);
        $this->assertEmpty($emptyUser);
    }

    public function testChangePassword()
    {
        $user = User::all()->random();
        $password = Str::random(8);

        $response = $this->actingAs($this->admin)->put(route('admin.users.password', $user->id), [
            '_token' => csrf_token(),
            'password' => $password,
            'password_confirmation' => $password
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check($password, $user->password));
    }

    public function testStore()
    {
        $data = User::factory()->make()->toArray();
        $data['_token'] = csrf_token();
        $data['roles'] = [Role::all()->random()->id];
        $data['content'] = Str::random(128);
        $data['password'] = Str::random(8);

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $user = User::orderBy('id', 'desc')->first();
        $this->assertEquals($data['name'], $user->name, 'Name');
        $this->assertEquals($data['first_name'], $user->first_name, 'First Name');
        $this->assertEquals($data['last_name'], $user->last_name, 'Last Name');
        $this->assertEquals($data['email'], $user->email, 'Email');
        $this->assertEquals($data['website'], $user->website, 'Website');
        $this->assertEquals($data['content'], $user->content()->first()->content, 'Content');
        $this->assertEquals($data['roles'], Arr::flatten($user->roles()->pluck('id')->values()->toArray()), 'Roles');
        $this->assertTrue(Hash::check($data['password'], $user->password), 'Password');
    }

    public function testUpdate()
    {
        $user = User::all()->random();
        $data = User::factory()->make()->toArray();
        $data['_token'] = csrf_token();
        $data['roles'] = [Role::all()->random()->id];
        $data['content'] = Str::random(128);

        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $user->id), $data);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals($data['name'], $user->name, 'Name');
        $this->assertEquals($data['first_name'], $user->first_name, 'First Name');
        $this->assertEquals($data['last_name'], $user->last_name, 'Last Name');
        $this->assertEquals($data['email'], $user->email, 'Email');
        $this->assertEquals($data['website'], $user->website, 'Website');
        $this->assertEquals($data['content'], $user->content()->first()->content, 'Content');
        $this->assertEquals($data['roles'], Arr::flatten($user->roles()->pluck('id')->values()->toArray()), 'Roles');
    }
}

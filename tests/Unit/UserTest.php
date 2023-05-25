<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testPageDisplayAllUser()
    {
        $users = User::factory()->count(5)->create();
        $response = $this->get('/user');
        $response->assertStatus(200);
        $response->assertViewIs('user.index');
        $response->assertViewHas('getAllUser');
        $response->assertViewHas('getAllUser', $users);
    }

    public function testPageCreateUser()
    {
        $response = $this->get('/user/create');
        $response->assertStatus(200);
        $response->assertViewIs('user.create');
    }

    public function testLogicStoreUser()
    {
        $fakeDataUser = [
            'uuid' => '41d450a1-eeae-4e89-a307-da309f682cca',
            'name' => 'kamil',
            'email' => 'kamil@gmail.com',
            'password' => 'password123',
        ];

        $response = $this->post('/user/store', $fakeDataUser);

        $response->assertStatus(302);
        $response->assertRedirect('/user');

        $this->assertDatabaseHas('users', [
            'name' => 'kamil',
            'email' => 'kamil@gmail.com',
        ]);
    }

    public function testPageShowUser()
    {
        $user = User::factory()->create();
        $response = $this->get('/user/' . $user->uuid);
        $response->assertStatus(200);
        $response->assertViewIs('user.show');
        $response->assertViewHas('getDataUser');
        $response->assertViewHas('getDataUser', $user);
    }

    public function testPageEditUser()
    {
        $user = User::factory()->create();
        $response = $this->get('/user/edit/' . $user->uuid);
        $response->assertStatus(200);
        $response->assertViewIs('user.edit');
        $response->assertViewHas('getDataUser');
        $response->assertViewHas('getDataUser', $user);
    }

    public function testLogicUpdateUser()
    {
        $userToCreate = User::factory()->create();
        $userToUpdate = [
            'name' => 'kamil',
            'email' => 'kamil@gmail.com',
            'password' => '123password',
        ];

        $response = $this->put('/user/update/' . $userToCreate->id, $userToUpdate);
        $response = $this->put('/user/update', array_merge($userToUpdate, ['uuid' => $userToCreate->uuid]));

        $response->assertStatus(302);
        $response->assertRedirect('/user');

        $refreshModelUser = $userToCreate->fresh();

        $this->assertEquals($userToUpdate['name'], $refreshModelUser->name);
        $this->assertEquals($userToUpdate['email'], $refreshModelUser->email);

        $userToCreate->delete();
    }

    public function testLogicDeleteUser()
    {
        $userToCreate = User::factory()->create();
        $response = $this->delete('/user/delete/' . $userToCreate->uuid);
        $response->assertRedirect('/user');
        $this->assertDatabaseMissing('users', ['id' => $userToCreate->id]);
    }
}

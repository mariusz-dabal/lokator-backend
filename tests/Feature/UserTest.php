<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->token = $this->user->createToken('lokator-api-token')->plainTextToken;
    }

    /** @test */
    public function a_list_of_users_can_be_fetched()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/api/users', $this->headers());

        $response->assertJsonCount(1)
            ->assertJson([
                'data' => [
                    [
                        'id' => $this->user->id
                    ]
                ]
            ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function an_authenticated_user_can_be_retrieved()
    {
        $response = $this->get('api/user', $this->headers());

        $response->assertJson([
            'data' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'flat_id' => $this->user->flat_id,
                'avatar_id' => $this->user->avatar_id,
                'color_id' => $this->user->color_id,
            ],
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

//
//    /** @test */
//    public function an_user_can_be_edited()
//    {
//        $this->withoutExceptionHandling();
//
//        $response = $this->patch('/user/' . $this->user->id, $this->data(), $this->headers());
//
//        $this->user = $this->user->fresh();
//
//        $this->assertEquals('Test User', $this->user->name);
//        $response->assertStatus(Response::HTTP_OK);
//    }

//    /** @test */
//    public function only_user_can_edit_user()
//    {
//
//    }

    private function data() {
        return [
            'name' => 'Test User',
        ];
    }

    private function headers()
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
        ];
    }
}

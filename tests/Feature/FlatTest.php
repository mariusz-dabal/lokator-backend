<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Flat;
use App\User;

class FlatTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->token = $this->user->createToken('lokator-api-token')->plainTextToken;
    }

    /** @test */
    public function an_authenticated_user_can_add_a_flat()
    {
        $response = $this->post('api/flats', $this->data(), $this->headers());

        $flat = Flat::first();
        $this->user = $this->user->fresh();

        $this->assertEquals('Test Flat', $flat->name);
        $this->assertEquals($this->user->flat->id, $flat->id);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /** @test */
    public function an_authenticated_user_can_not_replace_flat()
    {
        $this->post('api/flats', $this->data(), $this->headers());
        $this->user = $this->user->fresh();

        $flat = Flat::first();

        $response = $this->post('api/flats', $this->data(), $this->headers());
        $this->user = $this->user->fresh();

        $this->assertEquals($this->user->flat->id, $flat->id);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function fields_are_required()
    {
        collect(['name'])
            ->each(function($field) {
                $response = $this->post('api/flats', array_merge($this->data(), [$field => '']), $this->headers());

                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Flat::all());
            });
    }

    /** @test */
    public function a_flat_can_be_retrieved()
    {
        $flat = factory(Flat::class)->create();

        $response = $this->get('api/flats/' . $flat->id, $this->headers());

        $response->assertJson([
            'data' => [
                'name' => $flat->name,
            ]
        ]);
    }

    /** @test */
    public function a_flat_can_be_patched()
    {
        $flat = factory(Flat::class)->create();

        $response = $this->patch('api/flats/' . $flat->id, $this->data(), $this->headers());

        $flat = $flat->fresh();

        $response->assertJson([
            'data' => [
                'name' => $flat->name,
            ]
        ]);
    }

    /** @test */
    public function a_flat_can_be_deleted()
    {
        $flat = factory(Flat::class)->create();

        $response = $this->delete('api/flats/' . $flat->id, $this->data(), $this->headers());
        $this->assertCount(0, Flat::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function only_the_users_flat_can_be_retrieved()
    {
        $flat = factory(Flat::class)->create();

        $anotherUser = factory(User::class)->create();
        $token = $anotherUser->createToken('lokator-api-token')->plainTextToken;

        $response = $this->get('/api/flats/' . $flat->id, ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus(403);
    }


    private function data() {
        return [
            'name' => 'Test Flat',
        ];
    }

    private function headers()
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
        ];
    }
}

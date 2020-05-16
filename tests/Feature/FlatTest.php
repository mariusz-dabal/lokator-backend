<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use App\Flat;

class FlatTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function an_user_can_add_a_flat()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('api/flat', [
            'name' => 'Test flat',
        ]);

        $flat = Flat::first();

        $this->assertEquals('Test flat', $flat->name);
        $response->assertStatus(Response::HTTP_CREATED);
    }
}

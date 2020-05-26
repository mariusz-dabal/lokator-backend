<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class AvatarTest extends TestCase
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

//    /** @test */
//    public function a_list_of_avatars_can_be_retrieved()
//    {
//        $response = $this->get('/api/avatars', $this->headers());
//
//    }

    /** @test */
    public function an_avatar_can_be_stored()
    {
        $response = $this->post('/api/avatars', $this->data(), $this->headers());
        Storage::disk('public')->assertExists(trim($response->content(), 'public/'));
    }

    private function data() {
        return [
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ];
    }

    private function headers()
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
        ];
    }
}

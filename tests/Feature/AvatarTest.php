<?php

namespace Tests\Feature;

use App\Avatar;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
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
//        $avatar = factory(Avatar::class)->create();
//        dd($avatar);
//        $response = $this->get('/api/avatars', $this->headers());
//
//        $response->assertJson([
//            'data' => [
//                'avatar_id' => $avatar->id,
//                'url' => $avatar->url(),
//            ]
//        ]);
//
//    }
//
//    /** @test */
//    public function an_avatar_can_be_stored()
//    {
//        $response = $this->post('/api/avatars', $this->data(), $this->headers());
//        Storage::disk('avatars')->assertExists(trim($response->original['path'], 'avatars/'));
//    }
//
//    /** @test */
//    public function an_avatar_can_be_retrieved()
//    {
//        $avatar = factory(Avatar::class)->create();
//
//        $response = $this->get('api/avatars/' . $avatar->id, $this->headers());
//
//        $response->assertJson([
//            'data' => [
//                'avatar_id' => $avatar->id,
//                'url' => $avatar->url(),
//            ]
//        ]);
//        $response->assertStatus(Response::HTTP_OK);
//    }
//
//    /** @test */
//    public function an_avatar_can_be_patched()
//    {
//        $avatar = factory(Avatar::class)->create();
//
//        $response = $this->post('api/avatars/' . $avatar->id, $this->data(), $this->headers());
//
//        $patchedAvatar = $avatar->fresh();
//
//        $response->assertJson([
//            'data' => [
//                'avatar_id' => $patchedAvatar->id,
//                'url' => $patchedAvatar->url(),
//            ]
//        ]);
//        $response->assertStatus(Response::HTTP_OK);
//        Storage::disk('avatars')->assertExists(trim($patchedAvatar->path, 'avatars/'));
//        Storage::disk('avatars')->assertMissing(trim($avatar->path, 'avatars/'));
//    }

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

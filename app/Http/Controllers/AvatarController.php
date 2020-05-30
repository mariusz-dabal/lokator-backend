<?php

namespace App\Http\Controllers;

use App\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Avatar as AvatarResource;

class AvatarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return AvatarResource::collection(Avatar::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return false|string
     */
    public function store(Request $request)
    {
        $this->authorize('create', Avatar::class);

        $this->validateData();

        $path = $request->file('avatar')->store('avatars');

        $avatar = Avatar::create([
            'path' => $path,
        ]);

        return (new AvatarResource($avatar))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param Avatar $avatar
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function show(Avatar $avatar)
    {
        return (new AvatarResource($avatar))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Avatar $avatar
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(Avatar $avatar, Request $request)
    {
        $this->authorize('update', $avatar);

        $this->validateData();

        Storage::disk('avatars')->delete(trim($avatar->path, 'avatars/'));

        $path = $request->file('avatar')->store('avatars');

        $avatar->update([
            'path' => $path,
        ]);

        return (new AvatarResource($avatar))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Avatar $avatar
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function destroy(Avatar $avatar)
    {
        $this->authorize('delete', $avatar);

        $avatar->delete();

        return response()
            ->json('Avatar has been deleted')
            ->setStatusCode(Response::HTTP_OK);
    }

    private function validateData()
    {
        return request()->validate([
            'avatar' => 'required|file|max:2048'
        ]);
    }
}

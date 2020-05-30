<?php

namespace App\Http\Controllers;

use App\Avatar;
use App\Color;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display authorised user.
     *
     * @return UserResource
     */
    public function get()
    {
//        dd(auth()->user()->color()->get()->first());
        return new UserResource(auth()->user());
    }

    public function assignRole(User $user, Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|string|max:50',
        ]);

        $role = Role::where('name', $validatedData['role'])->first();

        if ($role === null) {
            return response()->json('The role does not exist', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($user->hasAnyRole($role->name)) {
            return response()->json("User already has {$role->name} role", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->roles()->save($role);

        return response()->json("You assigned {$role->name} role to the user {$user->email}", Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function index()
    {
        $this->authorize('viewAny', auth()->user());
        return UserResource::collection(User::all())
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validatedData = $this->validateData();

        $avatar = Avatar::find($validatedData['avatar_id']);
        $color = Color::find($validatedData['color_id']);

        if ($avatar === null) {
            return response()
                ->json('Avatar not found')
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($color === null) {
            return response()
                ->json('Color not found')
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->update($this->validateData());

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|object
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response()
            ->json('User has been deleted')
            ->setStatusCode(Response::HTTP_OK);
    }

    private function validateData()
    {
        return request()->validate([
            'name' => 'string|max:255',
            'avatar_id' => 'integer',
            'color_id' => 'integer',
        ]);
    }
}

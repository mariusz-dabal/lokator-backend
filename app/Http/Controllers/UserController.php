<?php

namespace App\Http\Controllers;

use App\Avatar;
use App\Color;
use App\Notifications\UserInviteNotification;
use App\Role;
use App\User;
use App\UserInvitation;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('registrationView', 'process_invites');
    }

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

    public function registrationView()
    {
        return view('auth.register');
    }

    public function process_invites(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email'
        ]);

        $validator->after(function ($validator) use ($request) {
            if (UserInvitation::where('email', $request->input('email'))->exists()) {
                $validator->errors()->add('email', 'There exists an invite with this email!');
            }
        });

        if ($validator->fails()) {
            return response('fail');
        }

        do {
            $token = Str::random(20);
        } while (UserInvitation::where('token', $token)->first());

        UserInvitation::create([
            'token' => $token,
            'email' => $request->input('email')
        ]);

        $url = URL::temporarySignedRoute(
            'registration', now()->addMinutes(300), ['token' => $token]
        );

        Notification::route('mail', $request->input('email'))->notify(new UserInviteNotification($url));

        return response('The Invite has been sent successfully');
    }
}

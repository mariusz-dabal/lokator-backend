<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User as UserResource;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json('Your credentials are incorrect. Please try again', 401);
        }

        $token = $user->createToken('lokator-api-token')->plainTextToken;

        $response = [
            'user' => new userResource($user),
            'api_token' => $token
        ];

        return response($response, 201);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach(Role::where('name', 'Tenant')->first());

        return new userResource($user);
    }


    public function logout (Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json('Logged Out successfully', 200);
    }
}

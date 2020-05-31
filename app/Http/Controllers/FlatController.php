<?php

namespace App\Http\Controllers;

use App\Flat;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Flat as FlatResource;

class FlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->flat()->count() > 0) {
            return response()->json('This user has assigned flat', Response::HTTP_FORBIDDEN);
        }

        $flat = Flat::create($this->validateData($request));

        $flat->users()->save($user);

        $user->attachRole('Flat Administrator');

        return (new FlatResource($flat))
            ->response()
            ->setStatusCode( Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Flat $flat
     * @return FlatResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Flat $flat)
    {
        $this->authorize('view', $flat);
        return new FlatResource($flat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Flat $flat
     * @return FlatResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Flat $flat)
    {
        $this->authorize('update', $flat);

        $flat->update($this->validateData($request));

        return new FlatResource($flat);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flat  $flat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flat $flat)
    {
        $flat->delete();
        return response('Flat  deleted successfully', Response::HTTP_NO_CONTENT);
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255'
        ]);
    }
}

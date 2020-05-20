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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();

        if ($user->flat()->count() > 0) {
            return response('This user has assigned flat', Response::HTTP_FORBIDDEN);
        }

        $flat = Flat::create($this->validateData($request));

        $user->flat_id = $flat->id;
        $user->save();

        return response($flat, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flat  $flat
     * @return FlatResource
     */
    public function show(Flat $flat)
    {
        return new FlatResource($flat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flat  $flat
     * @return FlatResource
     */
    public function update(Request $request, Flat $flat)
    {
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
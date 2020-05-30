<?php

namespace App\Http\Controllers;

use App\Color;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Color as ColorResource;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ColorResource::collection(Color::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Color $color
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(Request $request)
    {
        $this->authorize('create', Color::class);

        $color = Color::create($this->validateData());

        return (new ColorResource($color))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param Color $color
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function show(Color $color)
    {
        return (new ColorResource($color))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Color $color
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function update(Request $request, Color $color)
    {
        $this->authorize('update', $color);

        $color->update($this->validateData());

        return (new ColorResource($color))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Color $color
     * @return \Illuminate\Http\JsonResponse|object
     * @throws \Exception
     */
    public function destroy(Color $color)
    {
        $this->authorize('delete', $color);
        $color->delete();

        return response()
            ->json('Color has been deleted')
            ->setStatusCode(Response::HTTP_OK);
    }

    private function validateData()
    {
        return request()->validate([
            'name' => 'required|string|max:55'
        ]);
    }
}

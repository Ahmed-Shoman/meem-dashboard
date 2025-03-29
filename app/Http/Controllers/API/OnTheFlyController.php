<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OnTheFly;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OnTheFlyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(OnTheFly::all(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'presenter' => 'required|string|max:255',
            'presenter_image' => 'nullable|string',
            'image' => 'required|string',
            'seasons' => 'required|integer',
            'episodes' => 'required|integer',
            'program_name' => 'required|string',
            'is_active' => 'boolean',
            'program_description' => 'nullable|string',
            'instagram' => 'nullable|string',
            'snapchat' => 'nullable|string',
            'x' => 'nullable|string',
        ]);

        $onTheFly = OnTheFly::create($validated);

        return response()->json($onTheFly, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(OnTheFly $onTheFly)
    {
        return response()->json($onTheFly, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OnTheFly $onTheFly)
    {
        $validated = $request->validate([
            'presenter' => 'sometimes|string|max:255',
            'presenter_image' => 'nullable|string',
            'image' => 'sometimes|string',
            'seasons' => 'sometimes|integer',
            'episodes' => 'sometimes|integer',
            'program_name' => 'sometimes|string',
            'is_active' => 'boolean',
            'program_description' => 'nullable|string',
            'instagram' => 'nullable|string',
            'snapchat' => 'nullable|string',
            'x' => 'nullable|string',
        ]);

        $onTheFly->update($validated);

        return response()->json($onTheFly, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OnTheFly $onTheFly)
    {
        $onTheFly->delete();
        return response()->json(['message' => 'Deleted successfully'], Response::HTTP_NO_CONTENT);
    }
}

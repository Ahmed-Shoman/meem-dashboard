<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MissionSection;
use Illuminate\Http\Request;

class MissionSectionController extends Controller
{
    /**
     * Get all Mission Sections
     */
    public function index()
    {
        return response()->json(MissionSection::all(), 200);
    }

    /**
     * Get a single Mission Section
     */
    public function show($id)
    {
        $mission = MissionSection::find($id);
        if (!$mission) {
            return response()->json(['message' => 'Mission Section not found'], 404);
        }
        return response()->json($mission, 200);
    }

    /**
     * Create a new Mission Section
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'main_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'title2' => 'nullable|string|max:255',
            'description2' => 'nullable|string',
            'points' => 'nullable|array',
            'points.*.title' => 'required|string|max:255',
            'points.*.description' => 'nullable|string',
            'points.*.number' => 'required|integer',
        ]);

        $mission = MissionSection::create($validatedData);
        return response()->json($mission, 201);
    }

    /**
     * Update an existing Mission Section
     */
    public function update(Request $request, $id)
    {
        $mission = MissionSection::find($id);
        if (!$mission) {
            return response()->json(['message' => 'Mission Section not found'], 404);
        }

        $validatedData = $request->validate([
            'main_title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'title2' => 'nullable|string|max:255',
            'description2' => 'nullable|string',
            'points' => 'nullable|array',
            'points.*.title' => 'required|string|max:255',
            'points.*.description' => 'nullable|string',
            'points.*.number' => 'required|integer',
        ]);

        $mission->update($validatedData);
        return response()->json($mission, 200);
    }

    /**
     * Delete a Mission Section
     */
    public function destroy($id)
    {
        $mission = MissionSection::find($id);
        if (!$mission) {
            return response()->json(['message' => 'Mission Section not found'], 404);
        }

        $mission->delete();
        return response()->json(['message' => 'Mission Section deleted successfully'], 200);
    }
}
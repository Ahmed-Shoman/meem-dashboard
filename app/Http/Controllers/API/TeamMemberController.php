<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    /**
     * Get all Team Members
     */
    public function index()
    {
        return response()->json(TeamMember::all(), 200);
    }

    /**
     * Get a single Team Member
     */
    public function show($id)
    {
        $member = TeamMember::find($id);
        if (!$member) {
            return response()->json(['message' => 'Team Member not found'], 404);
        }
        return response()->json($member, 200);
    }

    /**
     * Create a new Team Member
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|string',
            'linkedin' => 'nullable|url',
        ]);

        $member = TeamMember::create($validatedData);
        return response()->json($member, 201);
    }

    /**
     * Update an existing Team Member
     */
    public function update(Request $request, $id)
    {
        $member = TeamMember::find($id);
        if (!$member) {
            return response()->json(['message' => 'Team Member not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'position' => 'sometimes|string|max:255',
            'image' => 'nullable|string',
            'linkedin' => 'nullable|url',
        ]);

        $member->update($validatedData);
        return response()->json($member, 200);
    }

    /**
     * Delete a Team Member
     */
    public function destroy($id)
    {
        $member = TeamMember::find($id);
        if (!$member) {
            return response()->json(['message' => 'Team Member not found'], 404);
        }

        $member->delete();
        return response()->json(['message' => 'Team Member deleted successfully'], 200);
    }
}
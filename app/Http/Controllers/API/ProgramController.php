<?php

namespace App\Http\Controllers\Api;

use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    // Display a listing of the programs.
    public function index()
    {
        $programs = Program::all(); // You can paginate if needed
        return response()->json($programs); // Return a collection of programs
    }

    // Store a newly created program in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_name' => 'required|string|max:255',
            'presenter' => 'nullable|string|max:255',
            'presenter_image' => 'nullable|image',
            'image' => 'nullable|image',
            'seasons' => 'nullable|integer',
            'episodes' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'instagram' => 'nullable|string|max:255',
            'snapchat' => 'nullable|string|max:255',
            'x' => 'nullable|string|max:255',
        ]);

        $program = Program::create($validated);

        return response()->json($program, 201); // Return the newly created program
    }

    // Display the specified program.
    public function show(Program $program)
    {
        return response()->json($program); // Return a single program
    }

    // Update the specified program in storage.
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'program_name' => 'nullable|string|max:255',
            'presenter' => 'nullable|string|max:255',
            'presenter_image' => 'nullable|image',
            'image' => 'nullable|image',
            'seasons' => 'nullable|integer',
            'episodes' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'instagram' => 'nullable|string|max:255',
            'snapchat' => 'nullable|string|max:255',
            'x' => 'nullable|string|max:255',
        ]);

        $program->update(array_filter($validated)); // Only update the fields that are passed

        return response()->json($program); // Return the updated program
    }

    // Remove the specified program from storage.
    public function destroy(Program $program)
    {
        $program->delete(); // Delete the program

        return response()->noContent(); // Return no content after deletion
    }
}

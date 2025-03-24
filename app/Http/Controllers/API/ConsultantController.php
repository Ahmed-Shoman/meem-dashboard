<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Models\Consultant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConsultantController extends Controller
{
    /**
     * Display a listing of the consultants.
     */
    public function index()
    {
        return response()->json(Consultant::all(), 200);
    }

    /**
     * Store a newly created consultant in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'linkedin' => 'nullable|url',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('consultants', 'public');
        }

        $consultant = Consultant::create([
            'name' => $request->name,
            'bio' => $request->bio,
            'image' => $imagePath,
            'linkedin' => $request->linkedin,
        ]);

        return response()->json(['message' => 'Consultant created successfully!', 'data' => $consultant], 201);
    }

    /**
     * Display the specified consultant.
     */
    public function show($id)
    {
        $consultant = Consultant::find($id);
        if (!$consultant) {
            return response()->json(['message' => 'Consultant not found'], 404);
        }
        return response()->json($consultant, 200);
    }

    /**
     * Update the specified consultant.
     */
    public function update(Request $request, $id)
    {
        $consultant = Consultant::find($id);
        if (!$consultant) {
            return response()->json(['message' => 'Consultant not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'linkedin' => 'nullable|url',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            if ($consultant->image) {
                Storage::disk('public')->delete($consultant->image);
            }
            $consultant->image = $request->file('image')->store('consultants', 'public');
        }

        $consultant->update($request->except(['image']));

        return response()->json(['message' => 'Consultant updated successfully!', 'data' => $consultant], 200);
    }

    /**
     * Remove the specified consultant from storage.
     */
    public function destroy($id)
    {
        $consultant = Consultant::find($id);
        if (!$consultant) {
            return response()->json(['message' => 'Consultant not found'], 404);
        }

        // Delete image if exists
        if ($consultant->image) {
            Storage::disk('public')->delete($consultant->image);
        }

        $consultant->delete();

        return response()->json(['message' => 'Consultant deleted successfully!'], 200);
    }
}
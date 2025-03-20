<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StorySection;
use Illuminate\Http\Request;

class StorySectionController extends Controller
{
    public function index()
    {
        $story = StorySection::first();
        return response()->json($story);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('uploads/story_section', 'public');
        }

        $story = StorySection::updateOrCreate(['id' => 1], $validatedData);

        return response()->json(['message' => 'Story Section Updated Successfully', 'data' => $story]);
    }
}
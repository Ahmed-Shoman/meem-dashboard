<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContentSection;

class ContentSectionController extends Controller
{
    public function index()
    {
        return response()->json(ContentSection::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $contentSection = ContentSection::create($request->all());

        return response()->json($contentSection, 201);
    }

    public function update(Request $request, $id)
    {
        $contentSection = ContentSection::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $contentSection->update($request->all());

        return response()->json($contentSection, 200);
    }

    public function destroy($id)
    {
        ContentSection::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
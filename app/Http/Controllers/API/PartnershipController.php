<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partnership;
use Illuminate\Http\Request;

class PartnershipController extends Controller
{
    public function index()
    {
        return response()->json(Partnership::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'cta_button_text' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('images')) {
            $validatedData['images'] = array_map(fn ($image) => $image->store('partnership_images', 'public'), $request->file('images'));
        }

        $partnership = Partnership::create($validatedData);

        return response()->json($partnership, 201);
    }

    public function update(Request $request, Partnership $partnership)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'cta_button_text' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png',
        ]);

        if ($request->hasFile('images')) {
            $validatedData['images'] = array_map(fn ($image) => $image->store('partnership_images', 'public'), $request->file('images'));
        }

        $partnership->update($validatedData);

        return response()->json($partnership);
    }

    public function destroy(Partnership $partnership)
    {
        $partnership->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
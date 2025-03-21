<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SliderSection;
use Illuminate\Http\Request;

class SliderSectionController extends Controller
{
    public function index()
    {
        return response()->json(SliderSection::all());
    }

    public function show($id)
    {
        return response()->json(SliderSection::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'slider_images' => 'nullable|array',
        ]);

        $sliderSection = SliderSection::create($data);

        return response()->json($sliderSection, 201);
    }

    public function update(Request $request, $id)
    {
        $sliderSection = SliderSection::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'slider_images' => 'nullable|array',
        ]);

        $sliderSection->update($data);

        return response()->json($sliderSection);
    }

    public function destroy($id)
    {
        SliderSection::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
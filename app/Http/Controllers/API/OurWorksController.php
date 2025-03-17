<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OurWork;
use Illuminate\Http\Request;

class OurWorksController extends Controller
{
    public function index()
    {
        return response()->json(OurWork::all(), 200);
    }

    public function show($id)
    {
        $ourWork = OurWork::find($id);

        if (!$ourWork) {
            return response()->json(['message' => 'OurWork not found'], 404);
        }

        return response()->json($ourWork, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'main_title' => 'required|string',
            'subtitle' => 'nullable|string',
            'cta_button_text' => 'nullable|string',
            'client_logos' => 'nullable|array',
            'description_text' => 'nullable|string',
            'listeners_stat' => 'nullable|string',
            'listeners_stat_description' => 'nullable|string',
            'episodes_stat' => 'nullable|string',
            'episodes_stat_description' => 'nullable|string',
            'programs_stat' => 'nullable|string',
            'programs_stat_description' => 'nullable|string',
            'program_list' => 'nullable|array',
            'banner_text' => 'nullable|string',
        ]);

        $ourWork = OurWork::create($validatedData);

        return response()->json($ourWork, 201);
    }

    public function update(Request $request, $id)
    {
        $ourWork = OurWork::find($id);

        if (!$ourWork) {
            return response()->json(['message' => 'OurWork not found'], 404);
        }

        $validatedData = $request->validate([
            'main_title' => 'required|string',
            'subtitle' => 'nullable|string',
            'cta_button_text' => 'nullable|string',
            'client_logos' => 'nullable|array',
            'description_text' => 'nullable|string',
            'listeners_stat' => 'nullable|string',
            'listeners_stat_description' => 'nullable|string',
            'episodes_stat' => 'nullable|string',
            'episodes_stat_description' => 'nullable|string',
            'programs_stat' => 'nullable|string',
            'programs_stat_description' => 'nullable|string',
            'program_list' => 'nullable|array',
            'banner_text' => 'nullable|string',
        ]);

        $ourWork->update($validatedData);

        return response()->json($ourWork, 200);
    }

    public function destroy($id)
    {
        $ourWork = OurWork::find($id);

        if (!$ourWork) {
            return response()->json(['message' => 'OurWork not found'], 404);
        }

        $ourWork->delete();

        return response()->json(['message' => 'OurWork deleted successfully'], 200);
    }
}
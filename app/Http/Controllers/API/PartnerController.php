<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        return response()->json(Partner::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logos' => 'nullable|array',
            'cta_text' => 'nullable|string',
            'cta_link' => 'nullable|url',
        ]);

        $partner = Partner::create($request->all());

        return response()->json(['message' => 'Partner created successfully!', 'data' => $partner], 201);
    }

    public function show($id)
    {
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['message' => 'Partner not found'], 404);
        }
        return response()->json($partner, 200);
    }

    public function update(Request $request, $id)
    {
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['message' => 'Partner not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'logos' => 'nullable|array',
            'cta_text' => 'nullable|string',
            'cta_link' => 'nullable|url',
        ]);

        $partner->update($request->all());

        return response()->json(['message' => 'Partner updated successfully!', 'data' => $partner], 200);
    }

    public function destroy($id)
    {
        $partner = Partner::find($id);
        if (!$partner) {
            return response()->json(['message' => 'Partner not found'], 404);
        }

        $partner->delete();

        return response()->json(['message' => 'Partner deleted successfully!'], 200);
    }
}
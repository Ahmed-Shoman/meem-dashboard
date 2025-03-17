<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutSection;

class AboutSectionController extends Controller
{
    // ✅ 1. عرض بيانات قسم "About"
    public function index()
    {
        return response()->json(AboutSection::first(), 200);
    }

    // ✅ 2. تحديث بيانات "About"
    public function update(Request $request, $id)
    {
        $about = AboutSection::find($id);
        if (!$about) {
            return response()->json(['message' => 'About section not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'background_media' => 'nullable|string',
            'cta_text' => 'string|max:255',
            'image' => 'nullable|string',
            'title2' => 'string|max:255',
            'sub_title2' => 'string|max:255',
            'sub_description2' => 'nullable|string',
        ]);

        $about->update($validatedData);

        return response()->json(['message' => 'About section updated successfully', 'data' => $about], 200);
    }

    // ✅ 3. إنشاء أول إدخال فقط (إذا لم يكن موجودًا)
    public function store(Request $request)
    {
        if (AboutSection::exists()) {
            return response()->json(['message' => 'An about section already exists'], 400);
        }

        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'background_media' => 'nullable|string',
            'cta_text' => 'string|max:255',
            'image' => 'nullable|string',
            'title2' => 'string|max:255',
            'sub_title2' => 'string|max:255',
            'sub_description2' => 'nullable|string',
        ]);

        $about = AboutSection::create($validatedData);

        return response()->json(['message' => 'About section created successfully', 'data' => $about], 201);
    }
}
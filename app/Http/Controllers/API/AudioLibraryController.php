<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AudioLibrary;
use Illuminate\Http\Request;

class AudioLibraryController extends Controller
{
    // **عرض جميع التسجيلات الصوتية**
    public function index()
    {
        return response()->json(AudioLibrary::all(), 200);
    }

    // **إضافة تسجيل صوتي جديد**
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'sound' => 'required|string',
            'sound_time' => 'required|string',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'sub_description' => 'nullable|string',
        ]);

        $audio = AudioLibrary::create($request->all());

        return response()->json($audio, 201);
    }

    // **عرض تسجيل صوتي واحد**
    public function show($id)
    {
        $audio = AudioLibrary::find($id);

        if (!$audio) {
            return response()->json(['message' => 'Audio not found'], 404);
        }

        return response()->json($audio, 200);
    }

    // **تحديث تسجيل صوتي**
    public function update(Request $request, $id)
    {
        $audio = AudioLibrary::find($id);

        if (!$audio) {
            return response()->json(['message' => 'Audio not found'], 404);
        }

        $audio->update($request->all());

        return response()->json($audio, 200);
    }

    // **حذف تسجيل صوتي**
    public function destroy($id)
    {
        $audio = AudioLibrary::find($id);

        if (!$audio) {
            return response()->json(['message' => 'Audio not found'], 404);
        }

        $audio->delete();

        return response()->json(['message' => 'Audio deleted successfully'], 200);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AudioLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AudioLibraryController extends Controller
{
    // **عرض جميع التسجيلات الصوتية**
    public function index()
    {
        $audioLibraries = AudioLibrary::with('user')->get();
        return response()->json($audioLibraries, 200);
    }

    // **إضافة تسجيل صوتي جديد**
    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'nullable|exists:programs,id',
            'episode_type' => 'required|string',
            'image' => 'required|string',
            'sound' => 'required|string',
            'sound_time' => 'required|string',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'sub_description' => 'nullable|string',
            'is_active' => 'boolean',
            'episode_number' => 'nullable|integer',
            'guest_name' => 'nullable|string',
            'youtube_link' => 'nullable|url',
            'apple_podcast_link' => 'nullable|url',
        ]);

        $audio = AudioLibrary::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        return response()->json($audio, 201);
    }

    // **عرض تسجيل صوتي واحد**
    public function show($id)
    {
        $audio = AudioLibrary::with('user')->find($id);

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

        if (Auth::id() !== $audio->user_id && !Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'program_id' => 'nullable|exists:programs,id',
            'episode_type' => 'required|string',
            'image' => 'required|string',
            'sound' => 'required|string',
            'sound_time' => 'required|string',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'sub_description' => 'nullable|string',
            'is_active' => 'boolean',
            'episode_number' => 'nullable|integer',
            'guest_name' => 'nullable|string',
            'youtube_link' => 'nullable|url',
            'apple_podcast_link' => 'nullable|url',
        ]);

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

        if (Auth::id() !== $audio->user_id && !Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $audio->delete();

        return response()->json(['message' => 'Audio deleted successfully'], 200);
    }
}

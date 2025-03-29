<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AudiobookEpisode;
use Illuminate\Http\Request;

class AudiobookEpisodeController extends Controller
{
    // عرض جميع الحلقات الصوتية
    public function index()
    {
        $episodes = AudiobookEpisode::all();
        return response()->json($episodes);
    }

    // إضافة حلقة صوتية جديدة
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'audiobook_id' => 'required|integer',
            'cover_image' => 'required|string',
            'audio_file' => 'required|string',
            'audio_duration' => 'required|string',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'category' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $episode = AudiobookEpisode::create($validatedData);
        return response()->json($episode, 201);
    }

    // تحديث حلقة صوتية
    public function update(Request $request, $id)
    {
        $episode = AudiobookEpisode::find($id);

        if (!$episode) {
            return response()->json(['message' => 'حلقة الصوت غير موجودة'], 404);
        }

        $validatedData = $request->validate([
            'audiobook_id' => 'required|integer',
            'cover_image' => 'nullable|string',
            'audio_file' => 'nullable|string',
            'audio_duration' => 'nullable|string',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'category' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $episode->update($validatedData);
        return response()->json($episode);
    }

    // حذف حلقة صوتية
    public function destroy($id)
    {
        $episode = AudiobookEpisode::find($id);

        if (!$episode) {
            return response()->json(['message' => 'حلقة الصوت غير موجودة'], 404);
        }

        $episode->delete();
        return response()->json(['message' => 'تم حذف الحلقة الصوتية بنجاح']);
    }
}
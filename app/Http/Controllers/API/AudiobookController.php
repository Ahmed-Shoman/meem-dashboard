<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Audiobook;
use Illuminate\Http\Request;

class AudiobookController extends Controller
{
    // عرض جميع الكتب الصوتية
    public function index()
    {
        $audiobooks = Audiobook::all();
        return response()->json($audiobooks);
    }

    // إضافة كتاب صوتي جديد
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'presenter' => 'required|string|max:255',
            'program_name' => 'required|string|max:255',
            'image' => 'nullable|image',
            'audio' => 'required|string',
            'audio_duration' => 'required|string',
            'is_active' => 'required|boolean',
            'description' => 'nullable|string',
        ]);

        $audiobook = Audiobook::create($validatedData);
        return response()->json($audiobook, 201);
    }

    // تحديث كتاب صوتي
    public function update(Request $request, $id)
    {
        $audiobook = Audiobook::find($id);

        if (!$audiobook) {
            return response()->json(['message' => 'الكتاب الصوتي غير موجود'], 404);
        }

        $validatedData = $request->validate([
            'presenter' => 'nullable|string|max:255',
            'program_name' => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'audio' => 'nullable|string',
            'audio_duration' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $audiobook->update($validatedData);
        return response()->json($audiobook);
    }

    // حذف كتاب صوتي
    public function destroy($id)
    {
        $audiobook = Audiobook::find($id);

        if (!$audiobook) {
            return response()->json(['message' => 'الكتاب الصوتي غير موجود'], 404);
        }

        $audiobook->delete();
        return response()->json(['message' => 'تم حذف الكتاب الصوتي بنجاح']);
    }
}
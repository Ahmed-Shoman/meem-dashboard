<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Header;

class HeaderController extends Controller
{
    /**
     * عرض بيانات الـ Header
     */
    public function index()
    {
        $header = Header::first();
        return response()->json($header);
    }

    /**
     * إنشاء أو تحديث بيانات الـ Header
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'logo' => 'nullable|string',
            'links' => 'nullable|array',
            'cta_text' => 'nullable|string',
        ]);

        // استخدام firstOrCreate لتحديث البيانات أو إنشائها إذا لم تكن موجودة
        $header = Header::updateOrCreate(['id' => 1], $validatedData);

        return response()->json([
            'message' => 'Header updated successfully',
            'data' => $header
        ]);
    }

    /**
     * حذف بيانات الـ Header (في حال كان هناك حاجة لذلك)
     */
    public function destroy()
    {
        $header = Header::first();
        if ($header) {
            $header->delete();
            return response()->json(['message' => 'Header deleted successfully']);
        }
        return response()->json(['message' => 'Header not found'], 404);
    }
}
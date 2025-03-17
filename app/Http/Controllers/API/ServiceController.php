<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * ✅ جلب جميع الخدمات
     */
    public function index()
    {
        return response()->json(Service::all(), 200);
    }

    /**
     * ✅ جلب خدمة معينة حسب الـ ID
     */
    public function show($id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }
        return response()->json($service, 200);
    }

    /**
     * ✅ إنشاء خدمة جديدة
     */
    public function store(Request $request)
    {
        // 🛑 التحقق من المدخلات
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'service_name' => 'required|string|max:255',
            'button_title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // ✅ إنشاء الخدمة
        $service = Service::create($request->all());

        return response()->json([
            'message' => 'Service created successfully',
            'service' => $service
        ], 201);
    }

    /**
     * ✅ تحديث بيانات الخدمة
     */
    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $service->update($request->all());

        return response()->json([
            'message' => 'Service updated successfully',
            'service' => $service
        ], 200);
    }

    /**
     * ✅ حذف خدمة
     */
    public function destroy($id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted successfully'], 200);
    }
}

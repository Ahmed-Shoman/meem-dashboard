<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\StudioBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudioBookingController extends Controller
{
    /**
     * ✅ جلب جميع الحجوزات
     */
    public function index()
    {
        return response()->json(StudioBooking::all(), 200);
    }

    /**
     * ✅ جلب حجز معين
     */
    public function show($id)
    {
        $booking = StudioBooking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }
        return response()->json($booking, 200);
    }

    /**
     * ✅ إنشاء حجز جديد
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description1' => 'nullable|string',
            'description2' => 'nullable|string',
            'studio_images' => 'nullable|array',
            'equipment_list' => 'nullable|array',
            'cta_button_text' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $booking = StudioBooking::create($request->all());

        return response()->json([
            'message' => 'Studio booking created successfully',
            'booking' => $booking
        ], 201);
    }

    /**
     * ✅ تحديث بيانات الحجز
     */
    public function update(Request $request, $id)
    {
        $booking = StudioBooking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->update($request->all());

        return response()->json([
            'message' => 'Studio booking updated successfully',
            'booking' => $booking
        ], 200);
    }

    /**
     * ✅ حذف حجز
     */
    public function destroy($id)
    {
        $booking = StudioBooking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Studio booking deleted successfully'], 200);
    }
}
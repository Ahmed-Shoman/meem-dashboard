<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionSection;

class SubscriptionSectionController extends Controller
{
    /**
     * 🟢 **جلب بيانات قسم الاشتراكات**
     */
    public function index()
    {
        $subscription = SubscriptionSection::first(); // إرجاع أول سجل
        return response()->json($subscription);
    }

    /**
     * 🟢 **إنشاء أو تحديث بيانات قسم الاشتراكات**
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'main_title' => 'required|string',
            'plan_name' => 'nullable|string',
            'plan_description' => 'nullable|string',
            'plan_price' => 'nullable|string',
            'plan_details' => 'nullable|array',
            'faqs_main_title' => 'nullable|string',
            'faqs' => 'nullable|array',
            'listen_now_title' => 'nullable|string',
            'listen_now_text' => 'nullable|string',
            'platform_links' => 'nullable|array',
            'listen_now_image' => 'nullable|string',
        ]);

        // تحديث أو إنشاء البيانات إذا لم تكن موجودة
        $subscription = SubscriptionSection::updateOrCreate(['id' => 1], $validatedData);

        return response()->json([
            'message' => 'Subscription section updated successfully',
            'data' => $subscription
        ]);
    }

    /**
     * 🟢 **حذف بيانات قسم الاشتراكات**
     */
    public function destroy()
    {
        $subscription = SubscriptionSection::first();
        if ($subscription) {
            $subscription->delete();
            return response()->json(['message' => 'Subscription section deleted successfully']);
        }
        return response()->json(['message' => 'Subscription section not found'], 404);
    }
}

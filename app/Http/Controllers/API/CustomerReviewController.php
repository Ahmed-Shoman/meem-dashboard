<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerReview;
use Illuminate\Http\Request;

class CustomerReviewController extends Controller
{
    public function index()
    {
        return response()->json(CustomerReview::all());
    }

    public function show($id)
    {
        return response()->json(CustomerReview::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'opinion' => 'required|string',
            'name' => 'required|string',
            'role' => 'nullable|string',
            'avatar' => 'nullable|string',
        ]);

        $customerReview = CustomerReview::create($data);

        return response()->json($customerReview, 201);
    }

    public function update(Request $request, $id)
    {
        $customerReview = CustomerReview::findOrFail($id);

        $data = $request->validate([
            'opinion' => 'required|string',
            'name' => 'required|string',
            'role' => 'nullable|string',
            'avatar' => 'nullable|string',
        ]);

        $customerReview->update($data);

        return response()->json($customerReview);
    }

    public function destroy($id)
    {
        CustomerReview::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
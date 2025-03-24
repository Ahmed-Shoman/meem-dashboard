<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FacebookHighlightSection;

class FacebookHighlightSectionController extends Controller
{
    public function index()
    {
        $data = FacebookHighlightSection::latest()->get();

        return response()->json($data);
    }
}
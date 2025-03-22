<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $news
        ]);
    }
}

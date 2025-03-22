<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MeemOriginal;

class MeemOriginalController extends Controller
{
    public function index()
    {
        $originals = MeemOriginal::latest()->get();

        return response()->json([
            'status' => true,
            'data' => $originals,
        ]);
    }
}
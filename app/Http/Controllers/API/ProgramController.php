<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    /**
     * ✅ جلب جميع البرامج
     */
    public function index()
    {
        return response()->json(Program::all(), 200);
    }

    /**
     * ✅ جلب برنامج معين حسب الـ ID
     */
    public function show($id)
    {
        $program = Program::find($id);
        if (!$program) {
            return response()->json(['message' => 'Program not found'], 404);
        }
        return response()->json($program, 200);
    }
}

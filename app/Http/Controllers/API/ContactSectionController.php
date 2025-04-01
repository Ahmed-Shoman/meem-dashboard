<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactSection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactSectionController extends Controller
{
    public function index()
    {
        return response()->json(ContactSection::all(), Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $section = ContactSection::create($data);

        return response()->json($section, Response::HTTP_CREATED);
    }

    public function show(ContactSection $contactSection)
    {
        return response()->json($contactSection, Response::HTTP_OK);
    }

    public function update(Request $request, ContactSection $contactSection)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $contactSection->update($data);

        return response()->json($contactSection, Response::HTTP_OK);
    }

    public function destroy(ContactSection $contactSection)
    {
        $contactSection->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
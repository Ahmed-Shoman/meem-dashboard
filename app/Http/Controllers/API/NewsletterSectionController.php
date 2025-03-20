<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSection;
use Illuminate\Http\Request;

class NewsletterSectionController extends Controller
{
    public function index()
    {
        return response()->json(NewsletterSection::first());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'main_title' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'cta_button_text' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('newsletter_images', 'public');
        }

        $newsletterSection = NewsletterSection::create($validatedData);

        return response()->json($newsletterSection, 201);
    }

    public function update(Request $request, NewsletterSection $newsletterSection)
    {
        $validatedData = $request->validate([
            'main_title' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'cta_button_text' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('newsletter_images', 'public');
        }

        $newsletterSection->update($validatedData);

        return response()->json($newsletterSection);
    }
}
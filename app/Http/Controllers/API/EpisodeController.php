<?php

namespace App\Http\Controllers\Api;

use App\Models\Episode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EpisodeController extends Controller
{
    // Display a listing of the episodes.
    public function index()
    {
        $episodes = Episode::all(); // You can paginate if needed
        return response()->json($episodes); // Return all episodes
    }

    // Store a newly created episode in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'program_id' => 'nullable|exists:programs,id',
            'episode_type' => 'required|string|max:255',
            'episode_number' => 'required|integer',
            'guest_name' => 'nullable|string|max:255',
            'youtube_link' => 'nullable|url',
            'apple_podcast_link' => 'nullable|url',
            'cover_image' => 'nullable|image',
            'audio_file' => 'nullable|file',
            'audio_duration' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $episode = Episode::create($validated); // Create episode with validated data

        return response()->json($episode, 201); // Return newly created episode
    }

    // Display the specified episode.
    public function show(Episode $episode)
    {
        return response()->json($episode); // Return single episode data
    }

    // Update the specified episode in storage.
    public function update(Request $request, Episode $episode)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'program_id' => 'nullable|exists:programs,id',
            'episode_type' => 'nullable|string|max:255',
            'episode_number' => 'nullable|integer',
            'guest_name' => 'nullable|string|max:255',
            'youtube_link' => 'nullable|url',
            'apple_podcast_link' => 'nullable|url',
            'cover_image' => 'nullable|image',
            'audio_file' => 'nullable|file',
            'audio_duration' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $episode->update($validated); // Update episode with validated data

        return response()->json($episode); // Return updated episode
    }

    // Remove the specified episode from storage.
    public function destroy(Episode $episode)
    {
        $episode->delete(); // Delete episode

        return response()->noContent(); // Return no content after deletion
    }
}

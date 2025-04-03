<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display a listing of the users.
    public function index()
    {
        $users = User::all(); // You can paginate if needed
        return response()->json($users); // Return raw user data as JSON
    }

    // Store a newly created user in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'is_admin' => 'nullable|boolean',
            'role' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image', 
            'social_media' => 'nullable|array',
            'assignable' => 'nullable|array',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $validated['is_admin'] ?? false,
            'role' => $validated['role'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'image' => $validated['image'] ?? null,
            'social_media' => $validated['social_media'] ?? [],
            'assignable' => $validated['assignable'] ?? [],
        ]);

        return response()->json($user, 201); // Return the newly created user as raw JSON
    }

    // Display the specified user.
    public function show(User $user)
    {
        return response()->json($user); // Return a single user as raw JSON
    }

    // Update the specified user in storage.
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'is_admin' => 'nullable|boolean',
            'role' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image',
            'social_media' => 'nullable|array',
            'assignable' => 'nullable|array',
        ]);

        $user->update(array_filter($validated)); // Only update the fields that are passed

        return response()->json($user); // Return the updated user as raw JSON
    }

    // Remove the specified user from storage.
    public function destroy(User $user)
    {
        $user->delete(); // Delete the user

        return response()->noContent(); // Return no content after deletion
    }
}

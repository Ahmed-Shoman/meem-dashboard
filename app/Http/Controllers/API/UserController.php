<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use App\Models\OnTheFly;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'image' => 'nullable|string',
            'bio' => 'nullable|string',
            'role' => 'nullable|string',
            'is_admin' => 'boolean',
            'assignable' => 'nullable|array', 
            'assignable.program_id' => 'nullable|integer',
            'assignable.program_name' => 'nullable|string',
            'assignable.program_type' => [
                'nullable',
                Rule::in(['بودكاست', 'عالطاير', 'كتب صوتية', 'جريدة']),
            ],
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Create the user
        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'sometimes|string|min:6',
            'image' => 'nullable|string',
            'role' => 'nullable|string',
            'bio' => 'nullable|string',
            'is_admin' => 'boolean',
            'assignable' => 'nullable|array',
            'assignable.program_id' => 'nullable|integer',
            'assignable.program_name' => 'nullable|string',
            'assignable.program_type' => [
                'nullable',
                Rule::in(['بودكاست', 'عالطاير', 'كتب صوتية', 'جريدة']),
            ],
        ]);

        // Hash the password if it's updated
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Update the user with the validated data
        $user->update($validated);

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}

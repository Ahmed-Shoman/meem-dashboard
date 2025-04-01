<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactRequestController extends Controller
{
    /**
     * Display a listing of the contact requests.
     */
    public function index()
    {
        return response()->json(Contact::all());
    }

    /**
     * Store a newly created contact request in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $contact = Contact::create($validated);

        return response()->json($contact, Response::HTTP_CREATED);
    }

    /**
     * Display the specified contact request.
     */
    public function show(Contact $contactRequest)
    {
        return response()->json($contactRequest);
    }

    /**
     * Update the specified contact request in storage.
     */
    public function update(Request $request, Contact $contactRequest)
    {
        $validated = $request->validate([
            'subject' => 'sometimes|string|max:255',
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'message' => 'sometimes|string',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $contactRequest->update($validated);

        return response()->json($contactRequest);
    }

    /**
     * Remove the specified contact request from storage.
     */
    public function destroy(Contact $contactRequest)
    {
        $contactRequest->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
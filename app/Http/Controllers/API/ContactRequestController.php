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

        return response()->json([
            'success' => true,
            'message' => 'Contact request submitted successfully.',
            'data' => $contact
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified contact request.
     */
    public function show(Contact $contact)
    {
        return response()->json($contact);
    }

    /**
     * Update the specified contact request in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'subject' => 'sometimes|string|max:255',
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'message' => 'sometimes|string',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $contact->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Contact request updated successfully.',
            'data' => $contact
        ]);
    }

    /**
     * Remove the specified contact request from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contact request deleted successfully.'
        ], Response::HTTP_NO_CONTENT);
    }
}

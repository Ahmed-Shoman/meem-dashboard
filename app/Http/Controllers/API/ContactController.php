<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // List all contacts
    public function index()
    {
        $contacts = Contact::all();
        return response()->json($contacts);
    }

    // Show a specific contact
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return response()->json($contact);
    }

    // Create a new contact
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'phone_number' => 'nullable|string|max:15',
        ]);

        $contact = Contact::create($validated);

        return response()->json([
            'message' => 'Contact created successfully',
            'data' => $contact
        ], 201);
    }

    // Update a contact
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'phone_number' => 'nullable|string|max:15',
        ]);

        $contact->update($validated);

        return response()->json([
            'message' => 'Contact updated successfully',
            'data' => $contact
        ]);
    }

    // Delete a contact
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfully']);
    }
}

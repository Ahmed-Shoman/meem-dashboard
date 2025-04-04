<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\NewsletterMails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterMailsController extends Controller
{
    /**
     * Display a listing of the emails.
     */
    public function index()
    {
        $emails = NewsletterMails::all();
        return response()->json([
            'status' => 'success',
            'data' => $emails,
        ], 200);
    }

    /**
     * Add a new email subscription.
     */
    public function store(Request $request)
    {
        // Validate the email provided in the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletter_mails,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Create a new subscription with the validated email
        $newsletterMail = NewsletterMails::create([
            'email' => $request->email,
        ]);

        // Return success response with the newly created email subscription
        return response()->json([
            'status' => 'success',
            'message' => 'Email added successfully',
            'data' => $newsletterMail,
        ], 201);
    }

    /**
     * This function is no longer needed as you don't send newsletters from this controller.
     */
    public function sendNewsletter(Request $request)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Sending newsletters is not supported in this controller.',
        ], 405);  // Method Not Allowed
    }
}

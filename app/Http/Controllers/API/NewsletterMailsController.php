<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\Newsletter;
use App\Models\NewsletterMails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterMailsController extends Controller
{
    /**
     * عرض قائمة الإيميلات
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
     * إضافة بريد إلكتروني جديد
     */
    public function store(Request $request)
    {
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

        $newsletterMail = NewsletterMails::create([
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Email added successfully',
            'data' => $newsletterMail,
        ], 201);
    }

    /**
     * إرسال نشرة بريدية إلى جميع الإيميلات
     */
    public function sendNewsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $emails = NewsletterMails::pluck('email');
        foreach ($emails as $email) {
            Mail::to($email)->send(new Newsletter($request->content));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Newsletter sent successfully to all subscribers',
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class SendMailController extends Controller
{
    public function index()
    {
        $mailData = [
            'title' => 'Mail from Laravel Db',
            'body' => 'This is for testing email using smtp.'
        ];

        Mail::to('nirbhayjadav07@gmail.com')->send(new SendMail($mailData));

        return response()->json(['message' => 'Email is sent successfully.']);
    }
}

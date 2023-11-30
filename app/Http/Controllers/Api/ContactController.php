<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function getInTouch(Request $request)
    {
        $request->validate([
            "name" => "required|max:100",
            "email" => "required|email|max:255",
            "body" => "required|max:1000",
        ]);
        $request_data = $request->only('name', 'email', 'body');

        Mail::send('emails.contact', $request_data, static function ($message) use ($request_data) {
            $message->to(env('MAIL_TO_ADDRESS'), 'DB')
                ->subject('DB Contact Form : Message from ' . $request_data['name'])
                ->from(env('MAIL_FROM_ADDRESS'), 'DB Contact Form');
        });

        Message::create($request_data);
        return response()->json(['message' => 'Message sent successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>'], 200);
    }
}

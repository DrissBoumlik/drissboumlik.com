<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getInTouch(Request $request)
    {
//        dd($request->all());
        $request->validate([
            "name" => "required|max:100",
            "email" => "required|email|max:255",
            "subject" => "required|max:5",
            "message" => "required|max:5",
        ]);
        Message::create($request->only('name', 'email', 'subject', 'message'));
        return response()->json(['message' => 'Message sent successfully', 'class' => 'alert-info', 'icon' => '<i class="fa fa-fw fa-circle-check"></i>'], 200);
    }}

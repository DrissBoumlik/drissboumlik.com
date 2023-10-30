<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Emails | Admin Panel';
        return view('admin.pages.messages', ['data' => $data]);
    }
}

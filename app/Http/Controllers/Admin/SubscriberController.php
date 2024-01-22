<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Subscriptions | Admin Panel';
        return view('admin.pages.subscriptions', ['data' => $data]);
    }
}

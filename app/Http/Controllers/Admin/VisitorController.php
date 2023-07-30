<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Visitors | Admin Panel';
        return view('admin.pages.visitors', ['data' => $data]);
    }
}

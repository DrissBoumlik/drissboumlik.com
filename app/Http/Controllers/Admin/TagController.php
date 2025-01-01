<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index(Request $request)
    {
        $data = adminPageSetup('Tags | Admin Panel');
        return view('admin.blog.tags.index', ['data' => $data]);
    }

}

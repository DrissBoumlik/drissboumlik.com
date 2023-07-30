<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\VisitorResource;
use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $visitors = Visitor::all();
        $visitors = VisitorResource::collection($visitors)->resolve();
        $visitors = \DataTables::of($visitors)->toJson();
        return $visitors;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function messages(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Messages | Admin Panel';
        return view('admin.pages.messages', ['data' => $data]);
    }

    public function subscriptions(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Subscriptions | Admin Panel';
        return view('admin.pages.subscriptions', ['data' => $data]);
    }

    public function visitors(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Visitors | Admin Panel';
        return view('admin.pages.visitors', ['data' => $data]);
    }

    public function visitorsCharts(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Charts | Visitors | Admin Panel';
        return view('admin.pages.charts', ['data' => $data]);
    }

    public function sitemap(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Sitemaps | Admin Panel';
        return view('admin.pages.sitemaps', ['data' => $data]);
    }
}

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

    public function testimonials(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Testimonials | Admin Panel';
        return view('admin.pages.testimonials', ['data' => $data]);
    }

    public function projects(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Projects | Admin Panel';
        return view('admin.pages.projects', ['data' => $data]);
    }

    public function services(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Services | Admin Panel';
        return view('admin.pages.services', ['data' => $data]);
    }

    public function menus(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Menus | Admin Panel';
        return view('admin.pages.menus', ['data' => $data]);
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

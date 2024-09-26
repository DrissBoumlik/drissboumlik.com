<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function messages(Request $request)
    {
        $data = adminPageSetup('Messages | Admin Panel');
        return view('admin.pages.messages', ['data' => $data]);
    }

    public function subscriptions(Request $request)
    {
        $data = adminPageSetup('Subscriptions | Admin Panel');
        return view('admin.pages.subscriptions', ['data' => $data]);
    }

    public function testimonials(Request $request)
    {
        $data = adminPageSetup('Testimonials | Admin Panel');
        return view('admin.pages.testimonials', ['data' => $data]);
    }

    public function projects(Request $request)
    {
        $data = adminPageSetup('Projects | Admin Panel');
        return view('admin.pages.projects', ['data' => $data]);
    }

    public function services(Request $request)
    {
        $data = adminPageSetup('Services | Admin Panel');
        return view('admin.pages.services', ['data' => $data]);
    }

    public function menus(Request $request)
    {
        $data = adminPageSetup('Menus | Admin Panel');
        return view('admin.pages.menus', ['data' => $data]);
    }

    public function menuTypes(Request $request)
    {
        $data = adminPageSetup('Menu Types | Admin Panel');
        return view('admin.pages.menu-types', ['data' => $data]);
    }

    public function visitors(Request $request)
    {
        $data = adminPageSetup('Visitors | Admin Panel');
        return view('admin.pages.visitors', ['data' => $data]);
    }

    public function visitorsCharts(Request $request)
    {
        $data = adminPageSetup('Charts | Visitors | Admin Panel');
        return view('admin.pages.charts', ['data' => $data]);
    }

    public function sitemap(Request $request)
    {
        $data = adminPageSetup('Sitemaps | Admin Panel');
        return view('admin.pages.sitemaps', ['data' => $data]);
    }
}

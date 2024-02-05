<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SitemapController extends Controller
{
    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Sitemaps | Admin Panel';
        return view('admin.pages.sitemaps', ['data' => $data]);
    }

    public function generateSitemap(Request $request)
    {
        $now = date("Y-m-d_h-i");
        $sitemap_archive_path = \Storage::disk('public')->path('sitemap-archive');
        $current_file = \Storage::disk('public')->path('sitemap.xml');
        \Spatie\Sitemap\SitemapGenerator::create('https://drissboumlik.com')->getSitemap()->writeToFile($current_file);
        \File::copy($current_file, $sitemap_archive_path . "/sitemap_$now.xml");
        return redirect('/sitemap');
    }
}

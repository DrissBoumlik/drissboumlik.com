<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Sitemap\SitemapGenerator;

class SitemapController extends Controller
{
    public function generateSitemap(Request $request)
    {
        $now = date("Y-m-d_h-i");
        $sitemap_archive_path = Storage::disk('public')->path('sitemap-archive');
        File::ensureDirectoryExists($sitemap_archive_path);
        $current_file = Storage::disk('public')->path('sitemap.xml');
        SitemapGenerator::create('https://drissboumlik.com')->getSitemap()->writeToFile($current_file);
        File::copy($current_file, $sitemap_archive_path . "/sitemap_$now.xml");
        return redirect('/sitemap');
    }
}

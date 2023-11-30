<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function sitemap(Request $request)
    {
        $filePath = \Storage::disk('public')->path('sitemap.xml') ;
        $filename = 'sitemap.xml';
        return \Response::make(file_get_contents($filePath), 200, [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
            // 'Content-Transfer-Encoding'=> 'binary',
            // 'Accept-Ranges'=> 'bytes'
        ]);
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

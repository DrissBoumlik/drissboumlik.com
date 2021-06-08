<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function sitemap(Request $request)
    {
        $filePath = public_path() . '/storage/sitemap.xml';
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
        $path = public_path() . '/storage/sitemap.xml';
        \Spatie\Sitemap\SitemapGenerator::create('https://resume.drissboumlik.com')->getSitemap()->writeToFile($path);
        return redirect('/sitemap');
    }
}

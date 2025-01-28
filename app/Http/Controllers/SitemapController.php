<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class SitemapController extends Controller
{
    public function sitemap(Request $request)
    {
        $filePath = Storage::disk('public')->path('sitemap.xml') ;
        $filename = 'sitemap.xml';
        return Response::make(file_get_contents($filePath), SymfonyResponse::HTTP_OK, [
            'Content-Type' => 'application/xml',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
            // 'Content-Transfer-Encoding'=> 'binary',
            // 'Accept-Ranges'=> 'bytes'
        ]);
    }

}

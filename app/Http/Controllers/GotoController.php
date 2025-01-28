<?php

namespace App\Http\Controllers;

use App\Models\ShortenedUrl;
use Illuminate\Http\Request;

class GotoController extends Controller
{

    public function goto(Request $request, $link)
    {
        $url = ShortenedUrl::where('slug', $link)
                            ->where('active', true)
                            ->first();
        if (!$url) {
            return redirect('/not-found');
        }
        return redirect($url->redirects_to);
    }

    public function not_found(Request $request)
    {
        $data = pageSetup('Page Not Found | Driss Boumlik', 'Page Not Found', ['header', 'footer']);
        return view('errors.404', ['data' => $data]);
    }
}

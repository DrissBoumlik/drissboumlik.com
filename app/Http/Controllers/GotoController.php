<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GotoController extends Controller
{
    private $home = '/';

    public function goto(Request $request, $link)
    {
        $url = getLinkByKey($link);
        if (!$url) {
            return redirect('/not-found');
        }
        return redirect($url);
    }

    public function not_found(Request $request)
    {
        $data = pageSetup('Page Not Found | Driss Boumlik', 'Page Not Found', true, true);
        return view('errors.404', ['data' => $data]);
    }
}

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
            return redirect_to_404_page();
        }
        return redirect($url);
    }

    public function not_found(Request $request, $var)
    {
        return redirect_to_404_page();
    }
}

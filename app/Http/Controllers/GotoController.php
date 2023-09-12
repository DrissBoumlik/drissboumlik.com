<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GotoController extends Controller
{
    private $home = '/';

    public function goto(Request $request, $link)
    {
        $links = getLinks();
        $url = null;
        if ($link && array_key_exists($link, $links)) {
            $url = $links[$link];
        }
        if (!$url) {
            $url = '/not-found';
        }
        return redirect($url);
    }

    public function not_found(Request $request)
    {
        return redirect_to_404_page();
    }
}

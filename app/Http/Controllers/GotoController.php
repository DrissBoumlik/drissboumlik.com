<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GotoController extends Controller
{
    private $home = '/';
    
    public function gotoExternalLink(Request $request, $link, $lang = null)
    {
        $lang = $lang ?? 'fr';
        if (!inLanguages($lang)) {
            return redirect('/resume');
        }
        \App::setLocale($lang);
        $links = getLinks(); //config('properties.links');
        $url = $this->home;
        if ($link && array_key_exists($link, $links)) {
            $url = $links[$link];
        }
        return redirect($url);
    }
}

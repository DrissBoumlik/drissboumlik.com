<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GotoController extends Controller
{
    private $home = '/';
    
    public function goto(Request $request, $link)
    {
        $links = getLinks(); //config('properties.links');
        $url = $this->home;
        if ($link && array_key_exists($link, $links)) {
            $url = $links[$link];
        }
        return redirect($url);
    }
}

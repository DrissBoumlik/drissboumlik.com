<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function resume(Request $request)
    {
        $data = new \stdClass();

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->footerMenu = getFooterMenu();

        $data->title = 'Resume | Driss Boumlik';

        return view('pages.resume.index', ['data' => $data]);
    }

}

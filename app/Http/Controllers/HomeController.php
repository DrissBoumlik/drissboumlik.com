<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request, $var = null)
    {
        $baseUrl = $request->getBaseUrl();
		if (strpos($baseUrl, 'public') != false || strpos($baseUrl, 'base') != false) {
			return \Redirect::to('https://drissboumlik.com');
		}
        return redirect('/');
    }
}

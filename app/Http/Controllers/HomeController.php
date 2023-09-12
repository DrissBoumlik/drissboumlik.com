<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request, $var = null)
    {
        $baseUrl = $request->getBaseUrl();
        if (strpos($baseUrl, 'public') != false || strpos($baseUrl, 'base') != false) {
            return redirect('/not-found');
        }
        if ($var) {
            return redirect('/not-found');
        }
        $data = new \stdClass;
        $data->activities = json_decode(\File::get(base_path() . '/database/data/activities.json'));
        $data->title = 'TeaCode | Turning Tea into Code';
        return view('pages.index', ['data' => $data]);
    }
}

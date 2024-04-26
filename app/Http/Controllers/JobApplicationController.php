<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function interactionDesignFoundation(Request $request)
    {
        $data = pageSetup('Senior PHP (Laravel) Developer | IxDF',
            null,
            true, true, true);
        return view('pages.job-applications.interaction-design-foundation', ['data' => $data]);
    }
}

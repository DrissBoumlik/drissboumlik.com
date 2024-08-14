<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function getPixel(Request $request)
    {
        return redirect('/assets/img/mixte/pixel.png');
    }
}

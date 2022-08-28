<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function resume(Request $request)
    {
        $data = new \stdClass();

        $data->sections = [];
        // $data->summary = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/summary.json"));
        $data->sections['competences'] = json_decode(\File::get(base_path() . "/database/data/resume/competences.json"));
        $data->sections['experiences'] = json_decode(\File::get(base_path() . "/database/data/resume/experiences.json"));
        $data->sections['education'] = json_decode(\File::get(base_path() . "/database/data/resume/education.json"));
        // $data->sections['portfolio'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/portfolio.json"));
        // $data->sections['certificates'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/certificates.json"));
        $data->sections['passion'] = json_decode(\File::get(base_path() . "/database/data/resume/passion.json"));
        $data->sections['other_exp'] = json_decode(\File::get(base_path() . "/database/data/resume/other_exp.json"));
        $data->sections['recommandations'] = json_decode(\File::get(base_path() . "/database/data/resume/recommandations.json"));

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->footerMenu = getFooterMenu();

        $data->title = 'Driss Boumlik | Resume';

        return view('pages.resume.index', ['data' => $data]);
    }

}

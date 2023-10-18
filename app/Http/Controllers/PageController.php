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
        $data->sections['experiences'] = json_decode(\File::get(base_path() . "/database/data/resume/experiences.json"));
        $data->sections['competences'] = json_decode(\File::get(base_path() . "/database/data/resume/competences.json"));
        $data->sections['education'] = json_decode(\File::get(base_path() . "/database/data/resume/education.json"));
        // $data->sections['portfolio'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/portfolio.json"));
        // $data->sections['certificates'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/certificates.json"));
        $data->sections['passion'] = json_decode(\File::get(base_path() . "/database/data/resume/passion.json"));
        $data->sections['other_exp'] = json_decode(\File::get(base_path() . "/database/data/resume/other_exp.json"));
        $data->sections['recommandations'] = json_decode(\File::get(base_path() . "/database/data/resume/recommandations.json"));
		$data->sections['recommandations']->items = collect($data->sections['recommandations']->items)->shuffle()->all();
        $data->sections['experiences']->items = array_map(function($item) {
            $item->duration = calculateDate($item->start_date, $item->end_date);
            return $item;
        }, $data->sections['experiences']->items);

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->footerMenu = getFooterMenu();

        $data->title = 'Resume | Driss Boumlik';

        return view('pages.resume.index', ['data' => $data]);
    }

}

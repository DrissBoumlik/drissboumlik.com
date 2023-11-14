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
        $data->sections['experiences'] = getExperiences();
        $data->sections['competences'] = getCompetences();
        $data->sections['education'] = getEducation();
        $data->sections['work'] = getWork();
        // $data->sections['certificates'] = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/certificates.json"));
        $data->sections['passion'] = getPassion();
        $data->sections['other_exp'] = getOtherExperiences();
        $data->sections['testimonials'] = getTestimonials();
		$data->sections['testimonials']->items = collect($data->sections['testimonials']->items)->shuffle()->all();
        $data->sections['experiences']->items = array_map(function($item) {
            $item->duration = calculateDate($item->start_date, $item->end_date);
            return $item;
        }, $data->sections['experiences']->items);

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();

        $data->title = 'Resume | Driss Boumlik';

        return view('pages.resume.index', ['data' => $data]);
    }

    public function testimonials(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Testimonials | Driss Boumlik';
        $data->headline = 'testimonials';
        $data->headerMenu = getHeaderMenu();
        $data->sections['testimonials'] = getTestimonials();
//        $data->sections['testimonials']->items = collect($data->sections['testimonials']->items)->shuffle()->all();

        return view('pages.testimonials', ['data' => $data]);
    }

}

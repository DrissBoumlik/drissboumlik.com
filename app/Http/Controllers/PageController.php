<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    public function about(Request $request)
    {
        $data = new \stdClass();

        $data->headline = 'about me';
        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->title = 'About me | Driss Boumlik';

        return view('pages.about', ['data' => $data]);
    }
    public function resume(Request $request)
    {
        $data = new \stdClass();

        $data->headline = 'resume';
        $data->sections = [];
        // $data->summary = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/summary.json"));
        $data->sections['experiences'] = getExperiences();
        $data->sections['competences'] = getCompetences();
        $data->sections['education'] = getEducation();
        $data->sections['work'] = getWork(onlyFeatured: true);
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

        return view('pages.resume', ['data' => $data]);
    }

    public function testimonials(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Testimonials | Driss Boumlik';
        $data->headline = 'testimonials';
        $data->headerMenu = getHeaderMenu();
        $data->testimonials = getTestimonials();
//        $data->sections['testimonials']->items = collect($data->sections['testimonials']->items)->shuffle()->all();

        return view('pages.testimonials', ['data' => $data]);
    }

    public function work(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Work | Driss Boumlik';
        $data->headline = 'work';
        $data->headerMenu = getHeaderMenu();
        $data->work = getWork();
        return view('pages.work', ['data' => $data]);
    }

    public function contact(Request $request)
    {
        $data = new \stdClass();
        $data->title = 'Contact | Driss Boumlik';
        $data->headline = 'contact';
        $data->headerMenu = getHeaderMenu();
        return view('pages.contact', ['data' => $data]);
    }

    public function getService(Request $request, $service)
    {
        $data = new \stdClass();
        $data->title = 'Services | Driss Boumlik';
        $data->headline = 'services';
        $data->headerMenu = getHeaderMenu();
        $data->socialLinks = getSocialLinks();
        $service = getServicesById($service);
        if (!$service) {
            return redirect_to_404_page();
        }
        return view('pages.services.index', ['data' => $data, 'service' => $service]);
    }
}

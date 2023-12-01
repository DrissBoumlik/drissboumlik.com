<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    public function about(Request $request)
    {
        $data = pageSetup('About me | Driss Boumlik', 'about me', true, true, true);
        return view('pages.about', ['data' => $data]);
    }
    public function resume(Request $request)
    {
        $data = pageSetup('Resume | Driss Boumlik', 'resume', true, true);

        $data->sections = [];
        // $data->summary = json_decode(\File::get(base_path() . "/database/data/resume/${lang}/summary.json"));
        $data->sections['experiences'] = getExperiences();
        $data->sections['competences'] = getSkills();
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

        return view('pages.resume', ['data' => $data]);
    }

    public function testimonials(Request $request)
    {
        $data = pageSetup('Testimonials | Driss Boumlik', 'testimonials', true, true);
        $data->testimonials = getTestimonials();
//        $data->sections['testimonials']->items = collect($data->sections['testimonials']->items)->shuffle()->all();

        return view('pages.testimonials', ['data' => $data]);
    }

    public function work(Request $request)
    {
        $data = pageSetup('Work | Driss Boumlik', 'work', true, true);
        $data->work = getWork();
        return view('pages.work', ['data' => $data]);
    }

    public function contact(Request $request)
    {
        $data = pageSetup('Contact | Driss Boumlik', 'contact', true, true);
        return view('pages.contact', ['data' => $data]);
    }

    public function privacyPolicy(Request $request)
    {
        $data = pageSetup('Privacy Policy | Driss Boumlik', 'privacy policy', true, true);
        return view('pages.privacy-policy', ['data' => $data]);
    }

    public function getService(Request $request, $service)
    {
        $data = pageSetup('Services | Driss Boumlik', 'services', true, true);
        $service = getServicesById($service);
        if (!$service) {
            return redirect('/not-found');
        }
        return view('pages.services.index', ['data' => $data, 'service' => $service]);
    }
}

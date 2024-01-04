<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class PageController extends Controller
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
        $data = pageSetup('Home | Driss Boumlik', null, true, true, true);
        $data->socialLinksCommunity = getSocialLinksCommunity();
        $data->sections = [];
        $data->sections['techs'] = getTechs();
        $data->sections['work'] = getWork(onlyFeatured: true);
        $data->sections['services'] = getServices();
        $data->sections['testimonials'] = getTestimonials();
//        $data->posts = $this->postService->getLatestFeaturedPosts();

        return view('pages.home', ['data' => $data]);
    }

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
//        $data->sections['certificates'] = getCertificates();
        $data->sections['passion'] = getPassion();
        $data->sections['non_it_experiences'] = getNonITExperiences();
        $data->sections['testimonials'] = getTestimonials();
        $data->sections['experiences']->data = array_map(function($item) {
            $item->duration = calculateDate($item->start_date, $item->end_date);
            return $item;
        }, $data->sections['experiences']->data);

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

    public function services(Request $request)
    {
        $data = pageSetup('Services | Driss Boumlik', 'services', true, true);
        $data->services = getServices();
        return view("pages.services", ['data' => $data]);
    }

    public function getService(Request $request, $service)
    {
        $serviceObj = getServicesById($service);
        if (!$serviceObj) {
            return redirect('/not-found');
        }
        $data = pageSetup("$serviceObj->text | Services | Driss Boumlik", 'services', true, true);
        return view("pages.services.partials.$service", ['data' => $data, 'service' => $serviceObj]);
    }
}

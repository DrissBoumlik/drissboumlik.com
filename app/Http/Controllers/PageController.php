<?php

namespace App\Http\Controllers;

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
        $data = cache_data('home-data', function() {
            $data = pageSetup('Home | Driss Boumlik', null, true, true, true);
            $data->socialLinksCommunity = getSocialLinksCommunity();
            $data->sections = [];
            $data->sections['techs'] = getTechs();
            $data->sections['work'] = getWork(onlyFeatured: true);
            $data->sections['services'] = getServices();
            $data->sections['testimonials'] = getTestimonials();
            return $data;
        }, 3600, $request->has('forget'));
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
        $data = cache_data('resume-data', function() {
            $data = pageSetup('Resume | Driss Boumlik', 'resume', true, true);

            $data->sections = [];
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
            return $data;
        }, 3600, $request->has('forget'));

        return view('pages.resume', ['data' => $data]);
    }

    public function testimonials(Request $request)
    {
        $data = cache_data('testimonials-data', function() {
            $data = pageSetup('Testimonials | Driss Boumlik', 'testimonials', true, true);
            $data->testimonials = getTestimonials();
            return $data;
        }, 3600, $request->has('forget'));

        return view('pages.testimonials', ['data' => $data]);
    }

    public function work(Request $request)
    {
        $data = cache_data('work-data', function() {
            $data = pageSetup('Work | Driss Boumlik', 'work', true, true);
            $data->work = getWork();
            return $data;
        }, 3600, $request->has('forget'));
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
        $data = cache_data('services-data', function() {
            $data = pageSetup('Services | Driss Boumlik', 'services', true, true);
            $data->services = getServices();
            return $data;
        }, 3600, $request->has('forget'));
        return view("pages.services", ['data' => $data]);
    }

}

<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }


    public function home(Request $request, $var = null)
    {
        $baseUrl = $request->getBaseUrl();
        if (strpos($baseUrl, 'public') != false || strpos($baseUrl, 'base') != false) {
            return redirect('/not-found');
        }
        if ($var) {
            return redirect('/not-found');
        }
        $data = $this->cacheService->cache_data('home-data', function() {
            $data = pageSetup('Home | Driss Boumlik', null, true, true, true, true);
            $data->sections = [];
//            $data->sections['techs'] = getTechs();
            // $data->sections['work'] = getWork(onlyFeatured: true);
            $data->sections['services'] = getServices();
            $data->sections['testimonials'] = getTestimonials();
            return $data;
        }, null, $request->has('forget'));
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
        $data = $this->cacheService->cache_data('resume-data', function() {
            $data = pageSetup('Resume | Driss Boumlik', 'resume', true, true);

            $data->sections = [];
            $data->sections['experiences'] = getExperiences();
            $data->sections['competences'] = getSkills();
            $data->sections['education'] = getEducation();
            $data->sections['projects'] = getProjects(onlyFeatured: true);
//        $data->sections['certificates'] = getCertificates();
            $data->sections['passion'] = getPassion();
            $data->sections['non_it_experiences'] = getNonITExperiences();
            $data->sections['testimonials'] = getTestimonials();
            $data->sections['experiences']->data = array_map(function($item) {
                $item->duration = calculateDate($item->start_date, $item->end_date);
                return $item;
            }, $data->sections['experiences']->data);
            return $data;
        }, null, $request->has('forget'));

        return view('pages.resume', ['data' => $data]);
    }

    public function testimonials(Request $request)
    {
        $data = $this->cacheService->cache_data('testimonials-data', function() {
            $data = pageSetup('Testimonials | Driss Boumlik', 'testimonials', true, true);
            $data->testimonials = getTestimonials();
            return $data;
        }, null, $request->has('forget'));

        return view('pages.testimonials', ['data' => $data]);
    }

    public function projects(Request $request)
    {
        $data = $this->cacheService->cache_data('projects-data', function() {
            $data = pageSetup('Projects | Driss Boumlik', 'projects', true, true);
            $data->projects = getProjects();
            return $data;
        }, null, $request->has('forget'));
        return view('pages.projects', ['data' => $data]);
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
        $data = $this->cacheService->cache_data('services-data', function() {
            $data = pageSetup('Services | Driss Boumlik', 'services', true, true);
            $data->services = getServices();
            return $data;
        }, null, $request->has('forget'));
        return view("pages.services", ['data' => $data]);
    }

}

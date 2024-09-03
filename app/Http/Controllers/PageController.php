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
            $data = pageSetup('Home | Driss Boumlik', null, ['header', 'footer', 'social', 'community']);
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
        $data = pageSetup('About me | Driss Boumlik', 'about me', ['header', 'footer', 'social']);
        return view('pages.about', ['data' => $data]);
    }

    public function resume(Request $request)
    {
        $data = $this->cacheService->cache_data('resume-data', function() {
            $data = pageSetup('Resume | Driss Boumlik', 'resume', ['header', 'footer']);

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
        $this->guestView = handleGuestView($request);
        $key = $this->cacheService->getCachedFullKey("testimonials-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Testimonials | Driss Boumlik', 'testimonials', ['header', 'footer']);
            $data->testimonials = getTestimonials(isGuest($this->guestView));
            return $data;
        }, null, $request->has('forget'));

        return view('pages.testimonials', ['data' => $data]);
    }

    public function projects(Request $request)
    {
        $this->guestView = handleGuestView($request);
        $key = $this->cacheService->getCachedFullKey("projects-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Projects | Driss Boumlik', 'projects', ['header', 'footer']);
            $data->projects = getProjects(isGuest($this->guestView));
            return $data;
        }, null, $request->has('forget'));
        return view('pages.projects', ['data' => $data]);
    }

    public function contact(Request $request)
    {
        $data = pageSetup('Contact | Driss Boumlik', 'contact', ['header', 'footer']);
        return view('pages.contact', ['data' => $data]);
    }

    public function privacyPolicy(Request $request)
    {
        $data = pageSetup('Privacy Policy | Driss Boumlik', 'privacy policy', ['header', 'footer']);
        return view('pages.privacy-policy', ['data' => $data]);
    }

    public function services(Request $request)
    {
        $this->guestView = handleGuestView($request);
        $key = $this->cacheService->getCachedFullKey("services-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Services | Driss Boumlik', 'services', ['header', 'footer']);
            $data->services = getServices(isGuest($this->guestView));
            return $data;
        }, null, $request->has('forget'));
        return view("pages.services", ['data' => $data]);
    }

}

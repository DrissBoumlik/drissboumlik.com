<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use App\Services\DataService;
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
        $this->guestView = isGuest(handleGuestView($request));
        $key = $this->cacheService->getCachedFullKey("home-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Home | Driss Boumlik', null, ['header', 'footer', 'social', 'community']);
            $data->sections = [];
            $data->sections['services'] = DataService::fetchFromDbTable("services", "Service", [
                                                'slug', 'title', 'icon', 'image', 'link',
                                                'description', 'active', 'order'
                                            ], $this->guestView);
            $data->sections['testimonials'] = DataService::fetchFromDbTable("testimonials", "Testimonial", [
                                                    'image', 'content', 'author', 'position', 'active', 'order'
                                                ], $this->guestView);
            return $data;
        }, null, $request->has('forget'));

        return view('pages.home', ['data' => $data]);
    }

    public function about(Request $request)
    {
        $data = pageSetup('About me | Driss Boumlik', 'about me', ['header', 'footer', 'social']);
        return view('pages.about', ['data' => $data]);
    }

    public function resume(Request $request)
    {
        $this->guestView = isGuest(handleGuestView($request));
        $key = $this->cacheService->getCachedFullKey("resume-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Resume | Driss Boumlik', 'resume', ['header', 'footer']);

            $data->sections = [];
            $data->sections['experiences'] = getExperiences();
            $data->sections['competences'] = getSkills();
            $data->sections['education'] = getEducation();
//        $data->sections['certificates'] = getCertificates();
            $data->sections['passion'] = getPassion();
            $data->sections['non_it_experiences'] = getNonITExperiences();
            $data->sections['experiences']->data = array_map(function($item) {
                $item->duration = calculateDate($item->start_date, $item->end_date);
                return $item;
            }, $data->sections['experiences']->data);

            $callback = $this->guestView ? fn($data) => $data->where('featured', true) : null;
            $data->sections['projects'] = DataService::fetchFromDbTable("projects", "Project",
                                                    [ 'image', 'role', 'title', 'description',
                                                        'featured', 'links', 'active', 'order' ], $this->guestView,
                                                    callback: $callback);
            $data->sections['testimonials'] = DataService::fetchFromDbTable("testimonials", "Testimonial",
                                                    [ 'image', 'content', 'author', 'position', 'active', 'order' ],
                                                    $this->guestView);
            return $data;
        }, null, $request->has('forget'));

        return view('pages.resume', ['data' => $data]);
    }

    public function testimonials(Request $request)
    {
        $this->guestView = isGuest(handleGuestView($request));
        $key = $this->cacheService->getCachedFullKey("testimonials-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Testimonials | Driss Boumlik', 'testimonials', ['header', 'footer']);
            $data->testimonials = DataService::fetchFromDbTable("testimonials", "Testimonial",
                                        [ 'image', 'content', 'author', 'position', 'active', 'order' ],
                                        $this->guestView);

            return $data;
        }, null, $request->has('forget'));

        return view('pages.testimonials', ['data' => $data]);
    }

    public function projects(Request $request)
    {
        $this->guestView = isGuest(handleGuestView($request));
        $key = $this->cacheService->getCachedFullKey("projects-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Projects | Driss Boumlik', 'projects', ['header', 'footer']);
            $data->projects = DataService::fetchFromDbTable("projects", "Project",
                                    [ 'image', 'role', 'title', 'description',
                                        'featured', 'links', 'active', 'order' ],
                                    $this->guestView);
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
        $this->guestView = isGuest(handleGuestView($request));
        $key = $this->cacheService->getCachedFullKey("services-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Services | Driss Boumlik', 'services', ['header', 'footer']);
            $data->services = DataService::fetchFromDbTable("services", "Service",
                [ 'slug', 'title', 'icon', 'image', 'link', 'description', 'active', 'order' ],
                $this->guestView);
            return $data;
        }, null, $request->has('forget'));
        return view("pages.services", ['data' => $data]);
    }

}

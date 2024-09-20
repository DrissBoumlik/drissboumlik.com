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
            $data->sections = [
                'services' => DataService::fetchFromDbTable("services", "Service", [
                                                            'slug', 'title', 'icon', 'image', 'link',
                                                            'description', 'active', 'order'
                                                        ], $this->guestView),
                'testimonials' => DataService::fetchFromDbTable("testimonials", "Testimonial", [
                                                            'image', 'content', 'author', 'position', 'active', 'order'
                                                        ], $this->guestView),
            ];
            return $data;
        }, null, $request->has('forget'));

        return view('pages.home', ['data' => $data]);
    }

    public function about(Request $request)
    {
        $data = pageSetup('About me | Driss Boumlik', 'about me', ['header', 'footer', 'social']);
        $data->page_data = (object) [
            "page_title" => "About",
            "page_description" => "About me",
            "page_type" => "AboutPage",
            "page_url" => \URL::to("/about"),
        ];

        $jsonld = [
            "@context" => "https://schema.org",
            "@type" => "AboutPage",
            "name" => "About",
            "headline" => "About",
            "description" => "About me",
            "author" => [
                "@type" => "Person",
                "name" => "Driss Boumlik"
            ]
        ];
        $data->page_data->jsonld = getJsonLD($jsonld);

        return view('pages.about', ['data' => $data]);
    }

    public function resume(Request $request)
    {
        $this->guestView = isGuest(handleGuestView($request));
        $key = $this->cacheService->getCachedFullKey("resume-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Resume | Driss Boumlik', 'resume', ['header', 'footer']);
            $data->page_data = (object) [
                "page_title" => "Resume",
                "page_description" => "Resume",
                "page_type" => "Person",
                "page_url" => \URL::to("/resume"),
            ];
            $jsonld = [
                "@context" => "https://schema.org",
                "@type" => "Person",
                "name" => "Driss Boumlik",
                "jobTitle" => "Software Developer",
                "description" => "Experienced software developer with a background in web development and a
                            strong focus on building scalable applications.",
                "url" => "https://drissboumlik.com/resume",
                "email" => "hi@drissboumlik.com",
                "sameAs" => [
                    "https://www.linkedin.com/in/drissboumlik",
                    "https://github.com/drissboumlik",
                    "https://twitter.com/drissboumlik"
                ],
                "knowsAbout" => [ "PHP", "Laravel", "JavaScript", "Typescript", "Angular" ],
            ];
            $data->page_data->jsonld = getJsonLD($jsonld);

            $callback = $this->guestView ? fn($data) => $data->where('featured', true) : null;
            $data->sections = [
                'experiences' => DataService::getExperiences(),
                'competences' => DataService::getSkills(),
                'education' => DataService::getEducation(),
                'passion' => DataService::getPassion(),
                'non_it_experiences' => DataService::getNonITExperiences(),
                'projects' => DataService::fetchFromDbTable("work", "Project",
                                                [ 'image', 'role', 'title', 'description',
                                                    'featured', 'links', 'active', 'order' ], $this->guestView,
                                                callback: $callback),
                'testimonials' => DataService::fetchFromDbTable("testimonials", "Testimonial",
                                                [ 'image', 'content', 'author', 'position', 'active', 'order' ],
                                                $this->guestView)
            ];
            // $data->sections['certificates'] = getCertificates();
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
        $this->guestView = isGuest(handleGuestView($request));
        $key = $this->cacheService->getCachedFullKey("testimonials-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Testimonials | Driss Boumlik', 'testimonials', ['header', 'footer']);
            $data->page_data = (object) [
                "page_title" => "Testimonials",
                "page_description" => "What others say about me",
                "page_type" => "Recommendation",
                "page_url" => \URL::to("/testimonials"),
            ];

            $jsonld = [
                "@context" => "https://schema.org",
                "@type" => "Recommendation",
                "name" => "Testimonials",
                "headline" => "Testimonials",
                "description" => "What others say about me",
                "author" => [
                    "@type" => "Person",
                    "name" => "Driss Boumlik",
                ]
            ];
            $data->page_data->jsonld = getJsonLD($jsonld);

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
            $data = pageSetup('Work | Driss Boumlik', 'work', ['header', 'footer']);
            $data->page_data = (object) [
                "page_title" => "Work",
                "page_description" => "Projects I built",
                "page_type" => "CreativeWork",
                "page_url" => \URL::to("/about"),
            ];
            $jsonld = [
                "@context" => "https://schema.org",
                "@type" => "CreativeWork",
                "name" => "Work",
                "headline" => "Work",
                "description" => "Projects I built",
                "author" => [
                    "@type" => "Person",
                    "name" => "Driss Boumlik",
                ]
            ];
            $data->page_data->jsonld = getJsonLD($jsonld);

            $data->projects = DataService::fetchFromDbTable("work", "Project",
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
        $data->page_data = (object) [
            "page_title" => "Contact",
            "page_description" => "Contact me",
            "page_type" => "ContactPage",
            "page_url" => \URL::to("/contact"),
        ];
        $jsonld = [
            "@context" => "https://schema.org",
            "@type" => "ContactPage",
            "name" => "Contact",
            "headline" => "Contact",
            "description" => "Contact me",
            "author" => [
                "@type" => "Person",
                "name" => "Driss Boumlik",
            ]
        ];
        $data->page_data->jsonld = getJsonLD($jsonld);


        return view('pages.contact', ['data' => $data]);
    }

    public function privacyPolicy(Request $request)
    {
        $data = pageSetup('Privacy Policy | Driss Boumlik', 'privacy policy', ['header', 'footer']);
        $data->page_data = (object) [
            "page_title" => "Privacy Policy",
            "page_description" => "Privacy Policy",
            "page_type" => "WebPage",
            "page_url" => \URL::to("/privacy-policy"),
        ];
        $jsonld = [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Privacy Policy",
            "headline" => "Privacy Policy",
            "description" => "Privacy Policy",
            "author" => [
                "@type" => "Person",
                "name" => "Driss Boumlik",
            ]
        ];
        $data->page_data->jsonld = getJsonLD($jsonld);
        return view('pages.privacy-policy', ['data' => $data]);
    }

    public function services(Request $request)
    {
        $this->guestView = isGuest(handleGuestView($request));
        $key = $this->cacheService->getCachedFullKey("services-data", '-with-non-active', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Services | Driss Boumlik', 'services', ['header', 'footer']);
            $data->page_data = (object) [
                "page_title" => "Services",
                "page_description" => "Services",
                "page_type" => "ProfessionalService",
                "page_url" => \URL::to("/services"),
            ];
            $jsonld = [
                "@context" => "https://schema.org",
                "@type" => "ProfessionalService",
                "name" => "Services",
                "description" => "Services",
            ];
            $data->page_data->jsonld = getJsonLD($jsonld);
            $data->services = DataService::fetchFromDbTable("services", "Service",
                [ 'slug', 'title', 'icon', 'image', 'link', 'description', 'active', 'order' ],
                $this->guestView);
            return $data;
        }, null, $request->has('forget'));
        return view("pages.services", ['data' => $data]);
    }

}

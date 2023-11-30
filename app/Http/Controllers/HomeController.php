<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $latestFeaturedPostsCount = 4;

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
        $data->sections['testimonials']->items = collect($data->sections['testimonials']->items)->shuffle()->all();
//        $posts = $this->getLatestFeaturedPosts();

        return view('pages.home', ['data' => $data]);
    }

    private function getLatestFeaturedPosts()
    {
        $posts = Post::where('featured', true)->where('status', 2); // Published Posts
        return (new PostCollection($posts->orderBy('updated_at', 'desc')->take($this->latestFeaturedPostsCount)->get()))->resolve();
    }
}

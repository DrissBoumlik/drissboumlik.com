<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $latestPostsCount = 4;

    public function home(Request $request, $var = null)
    {
        $baseUrl = $request->getBaseUrl();
        if (strpos($baseUrl, 'public') != false || strpos($baseUrl, 'base') != false) {
            return redirect('/not-found');
        }
        if ($var) {
            return redirect('/not-found');
        }
        $data = new \stdClass;
        $data->title = 'Home | Driss Boumlik';
        $data->headline = 'Latest Articles';
        $data->sections = [];
        $data->sections['recommandations'] = json_decode(\File::get(base_path() . "/database/data/resume/recommandations.json"));
        $data->sections['recommandations']->items = collect($data->sections['recommandations']->items)->shuffle()->all();
        $posts = $this->getLatestPosts();

        return view('pages.home', ['data' => $data, 'posts' => $posts]);
    }

    private function getLatestPosts()
    {
        return (new PostCollection(Post::where('featured', true)
            ->orderBy('updated_at', 'desc')->take($this->latestPostsCount)->get()))->resolve();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostWithPaginationCollection;
use App\Http\Resources\TagWithPaginationCollection;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Visitor;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $postsPerPage = 10;
    private $tagsPerPage = 20;


    public function getPosts(Request $request)
    {
        $result = $this->preparePosts(Post::with('author'));
        $data = pageSetup('Latest Articles | Blog', 'Latest Articles', true, true);
        $result['data'] = $data;
        return view('pages.blog.posts.index', $result);
    }

    public function getPost(Request $request, $slug)
    {
        $post = Post::where('slug', $slug);
        if (!\Auth::check()){
            $post = $post->where('status', 2); // Published Posts
        }
        $post = $post->first();
        if ($post === null) {
            return redirect('/not-found');
        }
        $ip = $request->ip();
        $visitor = Visitor::where('ip', $ip)
            ->where('url', "/blog/$slug")
            ->orderBy('updated_at', 'desc')->first();
        if ($visitor) {
            $timeSinceLastVisit = now()->diffInRealSeconds($visitor->updated_at);
            $timeSinceLastVisitMinValue = 7200; $aboutToVisit = 1;
            if ($timeSinceLastVisit > $timeSinceLastVisitMinValue || $timeSinceLastVisit < $aboutToVisit) {
                $post->increment('views', 1);
            }
        }
        $data = pageSetup("$post->title | Blog", 'Latest Articles', true, true);
        $post = (object)(new PostResource($post))->resolve();

        return view('pages.blog.posts.show', ['data' => $data, 'post' => $post]);
    }

    public function likePost(Request $request, $slug, $unlike = null)
    {
        $post = Post::where('slug', $slug)->first();
        $post->increment('likes', (bool) $unlike ? -1 : 1);
        return ['post' => $post];
    }

    public function getPostsByTag(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if ($tag == null) {
            return redirect('/not-found');
        }

        $result = $this->preparePosts($tag->posts()->with('author'));
        $data = pageSetup("Tags : $tag->name | Blog", "<a href='/tags'>All tags</a> <i class='fa-solid fa-angle-right mx-1'></i> $tag->name", true, true);
        $result['data'] = $data;
        return view('pages.blog.posts.index', $result);
    }

    public function getTags(Request $request)
    {
        $data = pageSetup('Tags | Blog', 'Tags', true, true);

        $data->tags_data = (new TagWithPaginationCollection(Tag::whereHas('posts', function($query) {
                if (!\Auth::check()){
                    $query->where('status', 2); // Published Posts
                }
            })
            ->orderBy('updated_at', 'desc')
            ->paginate($this->tagsPerPage)))->resolve();

        $tags = $data->tags_data['data'];
        unset($data->tags_data['data']);
//        $tags->collection = $tags->collection->shuffle();



        return view('pages.blog.tags.index', ['data' => $data, 'tags' => $tags]);
    }

    private function preparePosts($posts)
    {
        if (!\Auth::check()) {
            $posts = $posts->where('status', 2); // Published Posts
        }
        $posts_data = (object) (new PostWithPaginationCollection($posts
            ->orderBy('created_at', 'desc')
            ->paginate($this->postsPerPage)));

        $posts = $posts_data->resolve();

        return [
            'posts_data' => $posts_data,
            'posts' => $posts
        ];

    }
}

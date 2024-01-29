<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\SearchWithPaginationCollection;
use App\Http\Resources\TagWithPaginationCollection;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Visitor;
use App\Services\CacheService;
use App\Services\PostService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private const TAGS_PER_PAGE = 20;
    private const SEARCH_PER_PAGE = 10; // 5x2
    private PostService $postService;
    private CacheService $cacheService;

    public function __construct(PostService $postService, CacheService $cacheService)
    {
        $this->postService = $postService;
        $this->cacheService = $cacheService;
    }

    public function search(Request $request)
    {
        $term = $request->get('term');
        if (!$term) {
            return redirect('/blog');
        }
        $key = "search-data-$term" . (\Auth::check() ? '-with-unpublished' : '');
        $data = $this->cacheService->cache_data($key, function() use ($term) {
            $data = pageSetup("Search: $term | Blog", "Search results for : $term", true, true);
            $data->term = $term;
            if ($term) {
                $term = "%$term%";
            }
            $data->results_posts = \DB::table('posts');
            if (!\Auth::check()){
                $data->results_posts = $data->results_posts->where('published', true); // Published Posts
            }
            $data->results_posts = $data->results_posts->whereNull('deleted_at')
                ->where(function ($query) use ($term) {
                    $query->where('title', 'like', $term)
                        ->orWhere('excerpt', 'like', $term)
                        ->orWhere('description', 'like', $term)
                        ->orWhere('content', 'like', $term);
                })
                ->orderBy('updated_at', 'desc')
                ->select('title', \DB::Raw("concat('/blog/', slug) as link"), 'cover', \DB::Raw("'<i class=\"fa-solid fa-file-lines\"></i>' as type")); //->paginate($this->searchPerPage);
            $data->results = \DB::table('tags as t')->whereNull('t.deleted_at');
            if (!\Auth::check()){
                $data->results = $data->results
                            ->join('post_tag as pt', 't.id', '=', 'pt.tag_id')
                            ->join('posts as p', 'p.id', '=', 'pt.post_id')
                            ->whereNull('p.deleted_at')
                            ->where('p.published', true);
            }
            $data->results = $data->results->where(function ($query) use ($term) {
                $query->where('name', 'like', $term)
                    ->orWhere('t.description', 'like', $term);
            })
                ->orderBy('t.updated_at', 'desc')
                ->select('name as title', \DB::Raw("concat('/tags/', t.slug) as link"), 't.cover', \DB::Raw("'<i class=\"fa-solid fa-tag\"></i>' as type"))
                ->distinct()
                ->unionAll($data->results_posts)->paginate(self::SEARCH_PER_PAGE);
            $data->results_metadata = clone $data->results;
            $data->results = ((object) (new SearchWithPaginationCollection($data->results))->resolve())->items;
            unset($data->results_posts);
            return $data;
        }, null, $request->has('forget'));
        return view('pages.blog.search', ['data' => $data]);
    }

    public function getPosts(Request $request)
    {
        $key = "posts-data-" . (\Auth::check() ? '-with-unpublished' : '');
        $result = $this->cacheService->cache_data($key, function() {
            $result = $this->postService->preparePosts(Post::with('author', 'tags'));
            $data = pageSetup('Blog | Driss Boumlik', 'Blog', true, true);
            $result['data'] = $data;
            return $result;
        }, null, $request->has('forget'));
        return view('pages.blog.posts.index', $result);
    }

    public function getPost(Request $request, $slug)
    {
        $post = Post::where('slug', $slug);
        if (!\Auth::check()){
            $post = $post->where('published', true);
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
        $key = "post-data-$slug" . (\Auth::check() ? '-with-unpublished' : '');
        $data = $this->cacheService->cache_data($key, function() use ($post) {
            $data = pageSetup("$post->title | Blog", 'Latest Articles', true, true);
            $data->post = (object)(new PostResource($post))->resolve();
            return $data;
        }, null, $request->has('forget'));

        return view('pages.blog.posts.show', ['data' => $data, 'post' => $data->post]);
    }

    public function likePost(Request $request, $slug, int $value)
    {
        $post = Post::where('slug', $slug)->first();
        $post->increment('likes', $value);
        return ['post' => $post];
    }

    public function getPostsByTag(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->first();
        if ($tag == null) {
            return redirect('/not-found');
        }
        $key = "posts-tag-data-$slug" . (\Auth::check() ? '-with-unpublished' : '');
        $result = $this->cacheService->cache_data($key, function() use ($tag) {
            $result = $this->postService->preparePosts($tag->posts()->with('author', 'tags'));
            $data = pageSetup("Tags : $tag->name | Blog", "<a href='/tags'>All tags</a> <i class='fa-solid fa-angle-right mx-1'></i> $tag->name", true, true);
            $result['data'] = $data;
            return $result;
        }, null, $request->has('forget'));
        return view('pages.blog.posts.index', $result);
    }

    public function getTags(Request $request)
    {
        $key = 'tags-data' . (\Auth::check() ? '-with-unpublished' : '');
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Tags | Blog', 'Tags', true, true);

            $data->tags_data = (new TagWithPaginationCollection(Tag::whereHas('posts', function($query) {
                if (!\Auth::check()){
                    $query->where('published', true);
                }
            })->withCount('posts')->orderBy('updated_at', 'desc')->paginate(self::TAGS_PER_PAGE)));
            $data->tags = $data->tags_data->resolve();
            return $data;
        }, null, $request->has('forget'));

        return view('pages.blog.tags.index', ['data' => $data, 'tags' => $data->tags, 'tags_data' => $data->tags_data]);
    }

}

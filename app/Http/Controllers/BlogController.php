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
    private $guestView;

    public function __construct(PostService $postService, CacheService $cacheService)
    {
        $this->postService = $postService;
        $this->cacheService = $cacheService;
    }


    public function search(Request $request)
    {
        $this->guestView = isGuest(handleGuestView($request));
        $term = $request->get('term');
        if (!$term) {
            return redirect('/blog');
        }
        $page = $request->get('page');
        $key = $this->cacheService->getCachedFullKey("search-data-$term-$page", '-with-unpublished', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() use ($term) {
            $data = pageSetup("Search: $term | Blog", "Search results for : $term", ['header', 'footer']);
            $data->page_data = (object) [
                "page_title" => "Blog",
                "page_description" => "Articles about programming, tips and trick",
                "page_type" => "Blog",
                "page_image" => \URL::to("/assets/img/blog/default-post.webp"),
                "page_url" => \URL::to("/blog"),
            ];
            $data->term = $term;
            if ($term) {
                $term = "%$term%";
            }
            $data->results_posts = \DB::table('posts');
            if ($this->guestView) {
                $data->results_posts = $this->postService->publishedOnly($data->results_posts);
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
        $this->guestView = handleGuestView($request);
        $page = $request->get('page');
        $key = $this->cacheService->getCachedFullKey("posts-data-$page", '-with-unpublished', $this->guestView);
        $result = $this->cacheService->cache_data($key, function() {
            $result = $this->postService->preparePosts(Post::with('author', 'tags'), $this->guestView);
            $data = pageSetup('Blog | Driss Boumlik', 'Blog', ['header', 'footer']);
            $data->page_data = (object) [
                "page_title" => "Blog",
                "page_description" => "Articles about programming, tips and trick",
                "page_type" => "Blog",
                "page_image" => \URL::to("/assets/img/blog/default-post.webp"),
                "page_url" => \URL::to("/blog"),
            ];
            $result['data'] = $data;
            return $result;
        }, null, $request->has('forget'));
        return view('pages.blog.posts.index', $result);
    }

    public function getPost(Request $request, $slug)
    {
        $this->guestView = isGuest(handleGuestView($request));
        $post = Post::where('slug', $slug);
        if ($this->guestView) {
            $post = $this->postService->publishedOnly($post);
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
        $key = $this->cacheService->getCachedFullKey("post-data-$slug", '-with-unpublished', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() use ($post) {
            $data = pageSetup("$post->title | Blog", 'Latest Articles', ['header', 'footer']);
            $data->post = (object)(new PostResource($post))->resolve();
            $data->page_data = (object) [
                "page_title" => $data->post->title,
                "page_description" => $data->post->description ?? $data->post->excerpt,
                "page_type" => "Blog",
                "page_image" => \URL::to($data->post->cover?->original ?? "/assets/img/blog/default-post.webp"),
                "page_url" => \URL::to('/blog/' . $data->post->slug),
                "publication_date" => ($data->post->published_at ?? $data->post->updated_at)->toDateString(),
            ];
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
        $this->guestView = handleGuestView($request);
        $tag = Tag::where('slug', $slug)->first();
        if ($tag == null) {
            return redirect('/not-found');
        }
        $page = $request->get('page');
        $key = $this->cacheService->getCachedFullKey("posts-tag-data-$slug-$page", '-with-unpublished', $this->guestView);
        $result = $this->cacheService->cache_data($key, function() use ($tag) {
            $result = $this->postService->preparePosts($tag->posts()->with('author', 'tags'), $this->guestView);
            $data = pageSetup("Tags : $tag->name | Blog",
                "<a href='/tags'>All tags</a> <i class='fa-solid fa-angle-right mx-1'></i> $tag->name",
                ['header', 'footer']);
            $data->page_data = (object) [
                "page_title" => "Blog",
                "page_description" => "Articles about programming, tips and trick",
                "page_type" => "Blog",
                "page_image" => \URL::to("/assets/img/blog/default-post.webp"),
                "page_url" => \URL::to("/blog"),
            ];

            $result['data'] = $data;
            $result['tag'] = $tag;
            return $result;
        }, null, $request->has('forget'));
        return view('pages.blog.posts.index', $result);
    }

    public function getTags(Request $request)
    {
        $this->guestView = isGuest(handleGuestView($request));
        $key = $this->cacheService->getCachedFullKey('tags-data', '-with-unpublished', $this->guestView);
        $data = $this->cacheService->cache_data($key, function() {
            $data = pageSetup('Tags | Blog', 'Tags', ['header', 'footer']);
            $data->page_data = (object) [
                "page_title" => "Blog",
                "page_description" => "Articles about programming, tips and trick",
                "page_type" => "Blog",
                "page_image" => \URL::to("/assets/img/blog/default-post.webp"),
                "page_url" => \URL::to("/tags"),
            ];

            $data->tags_data = (new TagWithPaginationCollection(Tag::whereHas('posts', function($query) {
                if ($this->guestView) {
                    $this->postService->publishedOnly($query);
                }
            })->withCount('posts')->orderBy('updated_at', 'desc')->paginate(self::TAGS_PER_PAGE)));
            $data->tags = $data->tags_data->resolve();
            return $data;
        }, null, $request->has('forget'));

        return view('pages.blog.tags.index', ['data' => $data, 'tags' => $data->tags, 'tags_data' => $data->tags_data]);
    }

}

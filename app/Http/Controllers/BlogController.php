<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\PostWithPaginationCollection;
use App\Http\Resources\SearchWithPaginationCollection;
use App\Http\Resources\TagWithPaginationCollection;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $postsPerPage = 10;
    private $tagsPerPage = 20;

    private $searchPerPage = 10; // 5x2

    public function search(Request $request)
    {
        $term = $request->get('term');
        $data = new \stdClass();
        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->headline = "Search results for : $term";
        $data->term = $term;
        $data->title = "Search: $term | Blog";
        if ($term) {
            $term = "%$term%";
        }
        $data->results_posts = \DB::table('posts');
        if (!\Auth::check()){
            $data->results_posts = $data->results_posts->where('status', 2); // Published Posts
        }
        $data->results_posts = $data->results_posts->whereNull('deleted_at')
            ->where(function ($query) use ($term) {
                $query->where('title', 'like', $term)
                    ->orWhere('excerpt', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('content', 'like', $term);
            })
            ->orderBy('updated_at', 'desc')
            ->select('title', \DB::Raw("concat('/blog/', slug) as link"), 'cover', \DB::Raw("'<i class=\"fa-regular fa-file-lines\"></i>' as type")); //->paginate($this->searchPerPage);
        $data->results = \DB::table('tags')->whereNull('deleted_at');
//        if (!\Auth::check()){
//            $data->results =  $data->results->whereExists(\DB::table('posts')->where('posts.')->get());
//        }
        $data->results = $data->results->where(function ($query) use ($term) {
                $query->where('name', 'like', $term)
                    ->orWhere('description', 'like', $term);
            })
            ->orderBy('updated_at', 'desc')
            ->select('name as title', \DB::Raw("concat('/tags/', slug) as link"), 'cover', \DB::Raw("'<i class=\"fa-solid fa-tag\"></i>' as type"))
            ->unionAll($data->results_posts)->paginate($this->searchPerPage);
        $data->results_metadata = clone $data->results;
        $data->results = ((object) (new SearchWithPaginationCollection($data->results))->resolve())->items;
        return view('pages.blog.search', ['data' => $data]);
    }

    public function getPosts(Request $request)
    {
        $result = $this->preparePosts(Post::with('author'));

        $data = new \stdClass();
        $data->title = 'Latest Articles | Blog';
        $data->headline = 'Latest Articles';

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
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
            return redirect_to_404_page();
        }
        $post->increment('views', 1);
        $data = new \stdClass();
        $data->headline = 'Latest Articles';
        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();

        $post = (object)(new PostResource($post))->resolve();
        $data->title = "$post->title | ";

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
        $data = new \stdClass();
        $data->headline = 'Tags';
        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        if ($tag == null) {
            return redirect_to_404_page();
        }

        $result = $this->preparePosts($tag->posts()->with('author'));
        $data->title = "Tags : $tag->name | Blog";
        $data->headline = '<a href="/tags">All tags</a> <i class="fa-solid fa-angle-right mx-1"></i> ' . $tag->name;
        $result['data'] = $data;
        return view('pages.blog.posts.index', $result);
    }

    public function getTags(Request $request)
    {
        $data = new \stdClass();
        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->headline = 'Tags';

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


        $data->title = 'Tags | Blog';

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

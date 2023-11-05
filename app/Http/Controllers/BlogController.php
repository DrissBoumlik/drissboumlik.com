<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostWithPaginationCollection;
use App\Http\Resources\TagWithPaginationCollection;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $postsPerPage = 10;
    private $tagsPerPage = 20;


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
            $post = $post->where('status', 2);
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

        $data->tags_data = (new TagWithPaginationCollection(Tag::withCount('posts')
            ->orderBy('created_at', 'desc')
            ->paginate($this->tagsPerPage)))->resolve();

        $tags = $data->tags_data['data'];
        unset($data->tags_data['data']);


        $data->title = 'Tags | Blog';

        return view('pages.blog.tags.index', ['data' => $data, 'tags' => $tags]);
    }

    private function preparePosts($posts)
    {
        if (!\Auth::check()) {
            $posts = $posts->where('status', 2);
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

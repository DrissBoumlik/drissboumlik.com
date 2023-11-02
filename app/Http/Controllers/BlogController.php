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
    private $perPage = 10;


    public function getPosts(Request $request)
    {
        $result = $this->preparePosts(Post::with('author'));

        $data = new \stdClass();
        $data->title = 'Blog | Latest Articles';
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
        $data->title = 'Blog | ' . $post->title;

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
        $data->title = 'Blog | Tags';
        $data->headline = 'Tags';
        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        if ($tag == null) {
            return redirect_to_404_page();
        }

        $result = $this->preparePosts($tag->posts()->with('author'));
        $data->title = 'Blog | Tags | ' . $tag->name;
        $data->headline = 'Tags : ' . $tag->name;
        $result['data'] = $data;
        return view('pages.blog.posts.index', $result);
    }

    public function getTags(Request $request)
    {
        $data = new \stdClass();

        $data->tags_data = (new TagWithPaginationCollection(Tag::withCount('posts')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage)))->resolve();

        $tags = $data->tags_data['data'];
        unset($data->tags_data['data']);


        $data->title = 'Blog | Tags';

        return view('pages.blog.tags.index', ['data' => $data, 'tags' => $tags]);
    }

    private function preparePosts($posts)
    {
        if (!\Auth::check()) {
            $posts = $posts->where('status', 2);
        }
        $posts_data = (object) (new PostWithPaginationCollection($posts
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage)));

        $posts = $posts_data->resolve();

        return [
            'posts_data' => $posts_data,
            'posts' => $posts
        ];

    }
}

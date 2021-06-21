<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $data = new \stdClass();
        $data->posts = Post::orderBy('updated_at', 'desc')->get();

        $data->socialLinks = getSocialLinks();
        $data->menuFooter = getFooterMenu();

        return view('pages.blog.posts.index', ['data' => $data]);
    }

    private function showForm(Request $request, Post $post = null)
    {
        $data = new \stdClass();

        if ($post) {
            $data->post =  $post;
            $data->title = 'Edit Post';
            $data->route = '/posts/' . $post->id;
        } else {
            $data->title = 'Create Post';
            $data->route = '/posts';
        }

        $data->socialLinks = getSocialLinks();
        $data->menuFooter = getFooterMenu();

        return view('pages.blog.posts.edit', ['data' => $data]);
    }

    public function create(Request $request)
    {
        return $this->showForm($request);
    }

    public function edit(Request $request, Post $post)
    {
        return $this->showForm($request, $post);
    }

    private function postEdition(Request $request, Post $post = null)
    {
        try {
            \DB::beginTransaction();
            $tags = $request->input('tags');
            if ($tags) {
                $tags = explode(' ', $tags);
            }

            if ($post) {
                $post->update([
                    'title' => $request->input('title'),
                    'slug' => $request->input('slug'),
                    'body' => $request->input('body'),
                    'tags' => $tags
                ]);
                $message = 'Post Updated Successfully!';
            } else {
                $post = Post::create([
                    'title' => $request->input('title'),
                    'slug' => $request->input('slug'),
                    'body' => $request->input('body'),
                    'tags' => $tags
                ]);
                $message = 'Post Added Successfully!';
            }
            \DB::commit();

            $request->session()->flash('status', $message);
            $request->session()->flash('class', 'alert-success');
            return redirect('/posts/' . $post->id . '/edit');
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
            $request->session()->flash('status', $th->getMessage());
            $request->session()->flash('class', 'alert-warning');
            return redirect('/posts/' . $post->id . '/edit');
        }
    }

    public function store(Request $request)
    {
        return $this->postEdition($request);
    }

    public function update(Request $request, Post $post)
    {
        return $this->postEdition($request, $post);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\TestingsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BlogFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(TestingsSeeder::class);
    }

    public function test_displays_a_list_of_published_blog_posts(): void
    {
        $user = User::factory()->create();
        $posts = Post::factory(5)->create([
            'author_id' => $user->id,
            'published' => true,
            'published_at' => today(),
        ]);

        $response = $this->get('/blog?forget=1');

        $response->assertStatus(Response::HTTP_OK);

        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }
    }

    public function test_displays_a_single_published_blog_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'author_id' => $user->id,
            'published' => true,
            'published_at' => today(),
        ]);

        $response = $this->get("/blog/$post->slug");

        $response->assertStatus(Response::HTTP_OK);

        $response->assertSee($post->title);
        $response->assertSee($post->content);
    }

    public function test_not_displaying_unpublished_blog_posts(): void
    {
        $user = User::factory()->create();
        $posts = Post::factory(5)->create([
            'author_id' => $user->id,
            'published' => false,
            'published_at' => null,
        ]);

        $response = $this->get('/blog?forget=1');

        $response->assertStatus(Response::HTTP_OK);

        foreach ($posts as $post) {
            $response->assertDontSee($post->title);
        }
    }

    public function test_redirect_to_404_for_unpublished_single_blog_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'author_id' => $user->id,
            'published' => false,
        ]);

        $response = $this->get("/blog/$post->slug");

        $response->assertRedirect('/not-found');
    }

    public function test_displays_a_list_of_tags(): void
    {
        $user = User::factory()->create();
        $posts = Post::factory(5)->create([
            'author_id' => $user->id,
            'published' => true,
            'published_at' => today(),
        ]);
        $tags = Tag::factory(5)->create();

        $post_tag = [];

        for ($i = 0; $i < 10; $i++) {
            $tag_index = $i >= 5 ? 9 - $i : $i;
            $post_tag[] = [ 'post_id' => $posts[rand(0, 4)]->id, 'tag_id' => $tags[$tag_index]->id ];
        }
        DB::table('post_tag')->insert($post_tag);

        $response = $this->get('/tags?forget');

        $response->assertStatus(Response::HTTP_OK);

        foreach ($tags as $tag) {
            $response->assertSee($tag->name);
        }
    }

    public function test_displays_posts_by_tag(): void
    {
        $user = User::factory()->create();
        $posts = Post::factory(5)->create([
            'author_id' => $user->id,
            'published' => true,
            'published_at' => today(),
        ]);
        $tag = Tag::factory()->create();

        $post_tag = [];

        for ($i = 0; $i < 5; $i++) {
            $post_tag[] = [ 'post_id' => $posts[$i]->id, 'tag_id' => $tag->id ];
        }
        DB::table('post_tag')->insert($post_tag);

        $response = $this->get("/tags/$tag->slug");

        $response->assertStatus(Response::HTTP_OK);

        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }

    }

    public function test_redirect_to_404_for_null_tag(): void
    {
        $user = User::factory()->create();
        $posts = Post::factory(5)->create([
            'author_id' => $user->id,
            'published' => true,
            'published_at' => today(),
        ]);

        $response = $this->get("/tags/NonExistingTag");

        $response->assertRedirect('/not-found');

    }

    public function test_displays_list_of_post_matching_a_search_term(): void
    {
        $user = User::factory()->create();
        $post1 = Post::factory()->create([
            'title' => 'Php for beginners',
            'author_id' => $user->id,
            'published' => true,
            'published_at' => today(),
        ]);
        $post2 = Post::factory()->create([
            'title' => 'post2',
            'content' => 'Laravel is a php framework',
            'author_id' => $user->id,
            'published' => true,
            'published_at' => today(),
        ]);
        $post3 = Post::factory()->create([
            'title' => 'post3',
            'description' => 'Laravel is not a javascript framework',
            'author_id' => $user->id,
            'published' => true,
            'published_at' => today(),
        ]);

        $term = 'php';

        $response = $this->get("/search?term=$term");

        $response->assertStatus(Response::HTTP_OK);

        $response->assertSee($post1->title);
        $response->assertSee($post2->title);
        $response->assertDontSee($post3->title);
    }

    public function test_redirect_to_blog_if_term_is_empty(): void
    {
        $user = User::factory()->create();
        $posts = Post::factory(5)->create([
            'author_id' => $user->id,
            'published' => true,
            'published_at' => today(),
        ]);

        $response = $this->get("/search?term=");

        $response->assertRedirect('/blog');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class TestSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    function generateRandomColor() {
        $color = '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        return $color;
    }

    public function run()
    {
        if (User::count() == 0) {
            User::create([
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => Str::random(60),
            ]);
        }
        $faker = \Faker\Factory::create();

        // Tags
        $tags_data = [
            '.net',
            'basics',
            'c-langage',
            'c-sharp',
            'debug',
            'editors',
            'ide',
            'issues',
            'oop',
            'programming',
            'tricks',
        ];
        $tags = [];
        for($i = 0; $i < count($tags_data); $i++) {
            $name = $tags_data[$i];
            $tags[] = [
                "name" => $name,
                "slug" => \Str::slug($name),
                "color" => $this->generateRandomColor(),
                'description' =>  $faker->text(350),
                "created_at" => now(), "updated_at" => now()
            ];
        }
        Tag::insert($tags);

        return

        $posts = [];
        for($i = 1; $i <= 10; $i++) {
            $title = $faker->text(30);
            $content = $faker->text(1500);
            $posts[] = [
                'author_id' => 1,
                'title' => $title,
                'slug' => \Str::slug($title),
                'content' => $content,
                'excerpt' => \Str::words($content, 20),  // $faker->randomElement([null, $faker->text(200)]),
                'image' => $faker->imageUrl(1920, 1080),
                'description' =>  $faker->text(350),
                'status' => $faker->numberBetween(0, count(getPostStatus()) - 1),
                'featured' => $faker->boolean,
                'likes' => $faker->randomNumber(2),
                'views' => $faker->randomNumber(2),
                'published_at' => now(),
                "created_at" => now(), "updated_at" => now()
            ];
        }
        Post::insert($posts);

        $post_tag = [];
        for($i = 1; $i <= 30; $i++) {
            $post_id = Post::inRandomOrder()->first()->id;
            $tag_count = random_int(2, 6);
            if (!isset(collect($post_tag)->groupBy('post_id')[$post_id])) {
                $tags = Tag::inRandomOrder()->take($tag_count)->pluck('id');
                foreach ($tags as $tag_id) {
                    $post_tag[] = [
                        'tag_id' => $tag_id,
                        'post_id' => $post_id,
                        "created_at" => now(), "updated_at" => now()
                    ];
                }
            }
        }
        \DB::table('post_tag')->insert($post_tag);
    }
}

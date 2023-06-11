<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
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
        
        // Tags 
        $tags = [
            ["name" => 'php', "color" => $this->generateRandomColor(), "created_at" => now(), "updated_at" => now()], 
            ["name" => 'laravel', "color" => $this->generateRandomColor(), "created_at" => now(), "updated_at" => now()], 
            ["name" => 'html', "color" => $this->generateRandomColor(), "created_at" => now(), "updated_at" => now()],
            ["name" =>  'angular', "color" => $this->generateRandomColor(), "created_at" => now(), "updated_at" => now()], 
            ["name" => 'react', "color" => $this->generateRandomColor(), "created_at" => now(), "updated_at" => now()], 
            ["name" => 'cypress', "color" => $this->generateRandomColor(), "created_at" => now(), "updated_at" => now()]
        ];
        Tag::insert($tags);
        
        $faker = \Faker\Factory::create();
        $posts = [];
        for($i = 1; $i <= 10; $i++) {
            $posts[] = [
                'author_id' => 1,
                'title' => $faker->text(30),
                'slug' => $faker->slug,
                'content' => $faker->text(1500),
                'excerpt' => $faker->text(200),
                'image' => $faker->imageUrl(1920, 1080) ,
                'description' =>  $faker->text(350),
                'status' => $faker->randomElement(['published', 'draft', 'pending']),
                'featured' => $faker->boolean,
                'likes' => $faker->randomNumber(2),
                'views' => $faker->randomNumber(2),
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

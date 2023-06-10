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
            ["name" => 'php', "color" => $this->generateRandomColor()], 
            ["name" => 'laravel', "color" => $this->generateRandomColor()], 
            ["name" => 'html', "color" => $this->generateRandomColor()],
            ["name" =>  'angular', "color" => $this->generateRandomColor()], 
            ["name" => 'react', "color" => $this->generateRandomColor()], 
            ["name" => 'cypress', "color" => $this->generateRandomColor()]
        ];
        Tag::insert($tags);
        
        $faker = \Faker\Factory::create();
        $posts = [];
        for($i = 1; $i <= 10; $i++) {
            $posts[] = [
                'author_id' => 1,
                'title' => $faker->text(100),
                'slug' => $faker->slug,
                'content' => $faker->text(1500),
                'excerpt' => $faker->text(350),
                'image' => $faker->imageUrl($width = 1920, $height = 1080) ,
                'description' =>  $faker->text(350),
                'status' => $faker->randomElement(['published', 'draft', 'pending']),
                'featured' => $faker->boolean,
                'likes' => $faker->randomNumber(2),
                'views' => $faker->randomNumber(2),
            ];
        }
        Post::insert($posts);
        
    }
}

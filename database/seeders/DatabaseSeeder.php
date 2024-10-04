<?php

namespace Database\Seeders;

use App\Models\ShortenedUrl;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
//        $this->call([
//            TestSeeder::class,
//        ]);
//
//        $this->seedMenus();
//        $this->seedServices();
//        $this->seedTestimonials();
//        $this->seedProjects();

        $this->seedRedirectingLinks();

    }

    private function seedMenus()
    {
        $configFiles = [ 'header-menu', 'footer-menu', 'social-links', 'community-links' ];

        \Schema::disableForeignKeyConstraints();
        \App\Models\Menu::truncate();
        \App\Models\MenuType::truncate();
        \Schema::enableForeignKeyConstraints();
        foreach ($configFiles as $configFile) {
            $data = config("data.layout.$configFile");
            $menuType = \App\Models\MenuType::create([
                "name" => \Str::headline($configFile),
                "slug" => $configFile,
                "description" => "",
                "active" => 1,
            ]);
            foreach ($data as $index => $item) {
                try {
                    $_item = [
                        "text" => $item->title,
                        "title" => $item->title,
                        "slug" => $item->slug ?? \Str::slug($item->title),
                        "link" => $item->link ?? $item->slug,
                        "icon" => $item->icon ?? null,
                        "target" => $item->target ?? "_self",
                        "active" => !isset($item->hidden) || !$item->hidden,
                        "menu_type_id" => $menuType->id,
                        'order' => $index + 1,
                    ];
                    \App\Models\Menu::insert($_item);
                } catch (\Throwable $e) {
                    dd($item, $e->getMessage());
                }
            }
        }
    }

    private function seedServices()
    {
        $data = config("data.components.services")->data;

        \App\Models\Service::truncate();
        foreach ($data as $index => $item) {
            try {
                \App\Models\Service::insert([
                    'slug' => $item->id,
                    'title' => $item->text,
                    'icon' => $item->icon,
                    'image' => json_encode((object) [ 'original' => "assets/img/services/$item->img.svg",
                                            'compressed' => "assets/img/services/compressed/$item->img.webp" ]),
                    'link' => $item->link,
                    'description' => $item->description,
                    "active" => !isset($item->hidden) || !$item->hidden,
                    'order' => $index + 1,
                ]);
            } catch (\Exception $e) {
                dd($item, $e->getMessage());
            }
        }
    }

    private function seedTestimonials()
    {
        $data = config("data.resume.testimonials")->data;

        \App\Models\Testimonial::truncate();
        foreach ($data as $index => $item) {
            try {
                \App\Models\Testimonial::insert([
                    'content' => $item->content,
                    'author' => $item->author,
                    'image' => json_encode((object) [ 'original' => "assets/img/people/$item->icon",
                        'compressed' => "assets/img/people/$item->icon" ]),
                    'position' => $item->position,
                    "active" => !isset($item->hidden) || !$item->hidden,
                    'order' => $index + 1,
                ]);
            } catch (\Exception $e) {
                dd($item, $e->getMessage());
            }
        }
    }

    private function seedProjects()
    {
        $data = config("data.resume.work")->data;

        \App\Models\Project::truncate();
        foreach ($data as $index => $item) {
            try {
                \App\Models\Project::insert([
                    'role' => $item->content,
                    'title' => $item->name ?? '',
                    'description' => $item->description ?? '',
                    'featured' => $item->featured ?? false,
                    'links' => json_encode($item->links),
                    'image' => json_encode((object) [ 'original' => "assets/img/work/$item->image",
                        'compressed' => "assets/img/work/compressed/$item->image" ]),
                    "active" => !isset($item->hidden) || !$item->hidden,
                    'order' => $index + 1,
                ]);
            } catch (\Exception $e) {
                dd($item, $e->getLine(), $e->getMessage());
            }
        }
    }

    private function seedRedirectingLinks()
    {
        $links = getLinks();
        $data = [];
        foreach ($links as $key => $link) {
            $data[] = [
                'slug' => Str::slug($key),
                'title' => Str::camel($key),
                'shortened' => $key,
                'redirects_to' => $link,
                'active' => true,
            ];
        }
        ShortenedUrl::insert($data);
    }
}

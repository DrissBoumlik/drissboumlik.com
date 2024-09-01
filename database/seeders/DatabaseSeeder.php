<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        $this->call([
            TestSeeder::class,
        ]);

        $this->seedMenus();
        $this->seedServices();
        $this->seedTestimonials();
        $this->seedProjects();

    }

    private function seedMenus()
    {
        $configFiles = [ 'header-menu', 'footer-menu', 'social-links', 'social-links-community' ];

        \App\Models\Menu::truncate();
        foreach ($configFiles as $configFile) {
            $data = config("data.layout.$configFile");
            foreach ($data as $item) {
                try {
                    $_item = [
                        "text" => $item->title,
                        "title" => $item->title,
                        "slug" => $item->slug ?? \Str::slug($item->title),
                        "link" => $item->link ?? $item->slug,
                        "icon" => $item->icon ?? null,
                        "target" => $item->target ?? "_self",
                        "active" => !isset($item->hidden) || !$item->hidden,
                        "type" => $configFile,
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
        foreach ($data as $item) {
            try {
                \App\Models\Service::insert([
                    'slug' => $item->id,
                    'title' => $item->text,
                    'icon' => $item->icon,
                    'image' => $item->img,
                    'link' => $item->link,
                    'description' => $item->description,
                    "active" => !isset($item->hidden) || !$item->hidden,
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
        foreach ($data as $item) {
            try {
                \App\Models\Testimonial::insert([
                    'content' => $item->content,
                    'author' => $item->author,
                    'image' => $item->icon,
                    'position' => $item->position,
                    "active" => !isset($item->hidden) || !$item->hidden,
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
        foreach ($data as $item) {
            try {
                \App\Models\Project::insert([
                    'role' => $item->content,
                    'title' => $item->name ?? '',
                    'description' => $item->description ?? '',
                    'featured' => $item->featured ?? false,
                    'links' => json_encode($item->links),
                    'image' => $item->image,
                    "active" => !isset($item->hidden) || !$item->hidden,
                ]);
            } catch (\Exception $e) {
                dd($item, $e->getLine(), $e->getMessage());
            }
        }
    }
}

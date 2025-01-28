<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new DatabaseSeeder())->seedMenus();
        (new DatabaseSeeder())->seedServices();
        (new DatabaseSeeder())->seedTestimonials();
        (new DatabaseSeeder())->seedProjects();
        (new DatabaseSeeder())->seedRedirectingLinks();
    }
}

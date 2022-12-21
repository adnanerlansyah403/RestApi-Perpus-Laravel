<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [
            [
                "name" => "Romance",
                "slug" => "romance",
            ],
            [
                "name" => "Drama",
                "slug" => "drama",
            ],
            [
                "name" => "Sci-Fi",
                "slug" => "sci-fi",
            ],
            [
                "name" => "Fiction",
                "slug" => "fiction",
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

    }
}

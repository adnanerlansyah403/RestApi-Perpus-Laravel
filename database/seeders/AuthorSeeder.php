<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $authors = [
            [
                "name" => "Andrea Hirata",
                "email" => "andrea.harris@gmail.com",
                "gender" => "L",
                "birthdate" => "2003-03-27",
                "bio" => "Under a bright sunny sky, the three-day Byron Bay Writers’ Festival welcomed Andrea Hirata who charmed audiences with his modesty and gracious behavior during two sessions.",
            ],
            [
                "name" => "Pramoedya Ananta Toer",
                "email" => "pramoedya.toer@gmail.com",
                "gender" => "L",
                "birthdate" => "1989-04-18",
                "bio" => "Pramoedya Ananta Toer was an Indonesian author of novels, short stories, essays, polemics, and histories of his homeland and its people. ",
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }

    }
}

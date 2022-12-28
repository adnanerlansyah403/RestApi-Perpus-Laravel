<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\BookSeeder;

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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::query()->create([
            "name" => "Adnan Erlansyah",
            "email" => "adnanerlansyah@gmail.com",
            "password" => "12345",
            "email_verified_at" => now(),
            "remember_token" => Str::random(10)
        ]);

        $this->call([
            AuthorSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
        ]);

    }
}

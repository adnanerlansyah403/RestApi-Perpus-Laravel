<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $books = [
            [
                'title' => 'Bumi Manusia',
                'description' => 'Roman Tetralogi Buru mengambil latar belakang dan cikal bakal nation Indonesia di awal abad ke-20. Dengan membacanya waktu kita dibalikkan sedemikian rupa dan hidup di era membibitnya pergerakan nasional mula-mula, juga pertautan rasa, kegamangan jiwa, percintaan, dan pertarungan kekuatan anonim para srikandi yang mengawal penyemaian bangunan nasional yang kemudian kelak melahirkan Indonesia modern.',
                'publication_at' => "2000-06-28",
                'thick_of_book' => '1m',
                'size_of_book' => '4kg',
                'category_id' => 2,
                'author_id' => 2,
            ],
            [
                'title' => 'Laskar Pelangi',
                'description' => 'Roman Tetralogi Buru mengambil latar belakang dan cikal bakal nation Indonesia di awal abad ke-20. Dengan membacanya waktu kita dibalikkan sedemikian rupa dan hidup di era membibitnya pergerakan nasional mula-mula, juga pertautan rasa, kegamangan jiwa, percintaan, dan pertarungan kekuatan anonim para srikandi yang mengawal penyemaian bangunan nasional yang kemudian kelak melahirkan Indonesia modern.',
                'publication_at' => "2000-06-28",
                'thick_of_book' => '1m',
                'size_of_book' => '4kg',
                'category_id' => 4,
                'author_id' => 1
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{

    // fungsi nya untuk mengembalikan atau return data yg di request dari client ke server dan data kembalian nya berupa json
    public function index()
    {

        $data = []; // untuk menampung data dan akan di kembalikan ke client
        $books = Book::query()->get(); // mendapatkan semua data buku
        for($i = 0; $i < count($books); $i++) { // melakukan perulangan pada array buku
            $data[] = [
                'book' => [
                    'originalData' => $books[$i],
                    'author' => Author::query()->where("id", $books[$i]->author_id)->first(),
                    'category' => Category::query()->where("id", $books[$i]->category_id)->first()
                ],
            ]; // menambahkan data buku ke dalam variable data yg sblm nya sudah di deklarasikan, dan tampungan variable data tersebut berisi: ['originalData', 'author', 'category']. Jadi fungsi perulangan ini adalah untuk mendapatkan spesifikasi dari data2 lain yg ada pada buku, semisal seperti keterangan data author nya dan juga categorynya.
        }

        return response()->json([
            'status' => true,
            'message' => 'Get all books',
            'data' => $data
        ]); // mengembalikan response status berhasil dan message nya mendatkan semua buku beserta variable data yg sebelumnya sudah di olah.

    }

    
    public function show($id) // fungsinya untuk menampilkan spesifikasi data berdasarkan id yg dikirim dari parameter url 
    {
        $book = Book::query()->findOrFail($id); // mendapatkan satu data buku berdasarkan id yg sudah di kirim dari parameter

        $category = Category::query()->where("id", $book->category_id)->first(); // mendapatkan satu data category yg sesuai dengan kategori yang ada pada buku, bisa di dapatkan karena di data buku terdapat id_category yg mana id_category bisa di sesuaikan dengan id category yg ada di data category.
        $author = Author::query()->where("id", $book->author_id)->first(); // author pun sama hal nya dengan category

        return response()->json([
            "status" => true,
            "data" => [
                "book" => [
                    "originalData" => $book,
                    "author" => $author,
                    "category" => $category
                ]
            ]
        ]); // mengembalikan response status juga beserta dengan data2 dari satu buku yg telah di seleksi sebelumnya menggunakan id.

    }

    public function store(Request $request) // memasukkan data buku ke dalam database
    {
        $payload = $request->all(); // mendapatkan semua data request dari body input
        
        $validation = Validator::make($request->all(), [
            'title' =>'required|max:255',
            'description' =>'required|max:255',
            'publication_at' =>'required|date',
            'thick_of_book' =>'required|max:255',
            'size_of_book' =>'required|max:255',
            'cover' => 'nullable|max:255',
        ], [
            'title.required' => 'Title is required.',
            'description.required' => 'Description is required.',
            'publication_at.required' => 'Publication date is required.',
            'thick_of_book.required' => 'Thick of book is required.',
            'size_of_book.required' => 'Size of book is required.',
        ]);

        if($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        if($request->hasFile("cover")) { // mengecek apakah ada request input file yang bernama 'cover' yang di kirimkan melalui body, jika ada akan masuk ke kondisi ini.
            $payload['cover'] = $request->file("cover")->getClientOriginalName(); // memasukkan key baru ke dalam data array payload dengan nama 'cover' untuk di isi sebagai nama cover dari gambar tersebut
            $payload['cover_path'] = 'storage/' . $request->file("cover")->store("images_book", "public"); // sama dengan yg sebelumnya, line ini berfungsi untuk memasukkan key baru ke dalam variable array payload yg nanti nya di jadikan untuk data path dari gambar tersebut sekaligus meng upload nya ke folder public agar bisa di akses dari client/browser.
        }

        $book = Book::query()->create($payload); // membuat data buku baru dengan sesuai dari inputan data yg sudah di kirim dari request

        return response()->json([
            "status" => true,
            "message" => "Successfully created a new author",
            "data" => $book
        ]); // mengembalikan response status dan juga data buku yg baru saja di buat

    }

    public function update(Request $request, $id) 
    {
        $book = Book::query()->findOrFail($id); // mendapatkan satu data buku berdasarkan id yg sudah di kirim dari parameter
        
        $payload = $request->all(); // mendapatkan semua data request dari body input
        
        $validation = Validator::make($request->all(), [
            'title' =>'required|max:255',
            'description' =>'required|max:255',
            'publication_at' =>'required|date',
            'thick_of_book' =>'required|max:255',
            'size_of_book' =>'required|max:255',
            'cover' => 'required|max:255',
            'rising_city' =>'required|max:255',
            'age_rating' =>'required|max:255',
        ]);

        if($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }
        
        if($request->hasFile("cover")) { // mengecek apakah ada request input file yang bernama 'cover' yang di kirimkan melalui body, jika ada akan masuk ke kondisi ini.
            file_exists($book->cover_path) ? unlink(public_path($book->cover_path)) : false; // line ini berfungsi untuk mengecek apakah file gambar tersebut ada di path yg telah di beri tahukan oleh data cover_path, jika ada maka hapus file gambar tersebut dari public dan jika tidak maka akan mengembalikan false
            $payload['cover'] = file_exists($book->cover_path) ? $book->cover : $request->file("cover")->getClientOriginalName(); // ini juga sama seperti di atas, hanya saja jika true akan menggunakan data cover book dari yg sblmnya, jika false maka akan menggunakan nama data cover baru
            $payload['cover_path'] = file_exists($book->cover_path) ? $book->cover_path : 'storage/' . $request->file("cover")->store("images_book", "public"); // ini juga sama seperti cover hanya saja ini adalah untuk data cover_path
        }

        $book->update($payload); // update buku tersebut

        return response()->json([
            "status" => true,
            "message" => "Successfully updated the book",
            "data" => $book
        ]); // mengembalikan response status dan juga message success updated book beserta mengirimkan data book yg baru saja di update

    }

    public function destroy($id)
    {
        $book = Book::query()->findOrFail($id); // mendapatkan satu data buku berdasarkan id yg sudah di kirim dari parameter

        file_exists($book->cover_path) ? 
        unlink(public_path($book->cover_path)) :
        false; // line ini berfungsi untuk mengecek apakah file gambar tersebut ada di path yg telah di beri tahukan oleh data cover_path, jika ada maka hapus file gambar tersebut dari public dan jika tidak maka akan mengembalikan false

        $book->delete(); // delete buku sesuai id dari parameter yg di kirimkan

        return response()->json([
            "status" => true,
            "message" => "Successfully deleted the author",
            "data" => null
        ]); // mengembalikan response status dan message sucess deleted author

    }

}

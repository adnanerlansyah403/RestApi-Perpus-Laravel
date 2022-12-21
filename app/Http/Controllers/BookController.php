<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {

        $data = [];
        $books = Book::query()->get();
        // dd($books);
        for($i = 0; $i < count($books); $i++) {
            $data[] = [
                'book' => [
                    'originalData' => $books[$i],
                    'author' => Author::query()->where("id", $books[$i]->author_id)->first(),
                    'category' => Category::query()->where("id", $books[$i]->category_id)->first()
                ],
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Get all books',
            'data' => $data
        ]);

    }

    
    public function show($id) 
    {
        $book = Book::query()->findOrFail($id);

        $category = Category::query()->where("id", $book->category_id)->first();
        $author = Author::query()->where("id", $book->author_id)->first();

        return response()->json([
            "status" => true,
            "data" => [
                "book" => [
                    "originalData" => $book,
                    "author" => $author,
                    "category" => $category
                ]
            ]
        ]);

    }

    public function store(Request $request) 
    {

        $payload = $request->all();

        if($request->hasFile("cover")) {
            $payload['cover'] = $request->file("cover")->getClientOriginalName();
            $payload['cover_path'] = 'storage/' . $request->file("cover")->store("images_book", "public");
        }

        $book = Book::query()->create($payload);

        return response()->json([
            "status" => true,
            "message" => "Successfully created a new author",
            "data" => $book
        ]);

    }

    public function update(Request $request, $id) 
    {
        $book = Book::query()->findOrFail($id);
        
        $payload = $request->all();
        
        if($request->hasFile("cover")) {
            file_exists($book->cover_path) ? unlink(public_path($book->cover_path)) : false;
            $payload['cover'] = file_exists($book->cover_path) ? $book->cover : $request->file("cover")->getClientOriginalName();
            $payload['cover_path'] = file_exists($book->cover_path) ? $book->cover_path : 'storage/' . $request->file("cover")->store("images_book", "public");
        }

        $book->update($payload);

        return response()->json([
            "status" => true,
            "message" => "Successfully updated the author",
            "data" => $book
        ]);

    }

    public function destroy($id)
    {
        $book = Book::query()->findOrFail($id);

        file_exists($book->cover_path) ? 
        unlink(public_path($book->cover_path)) :
        false;

        $book->delete();

        return response()->json([
            "status" => true,
            "message" => "Successfully deleted the author",
            "data" => null
        ]);

    }

}

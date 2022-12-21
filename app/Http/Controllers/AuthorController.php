<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    
    public function index()
    {

        $authors = Author::query()->get();

        return response()->json([
            "status" => true,
            "data" => $authors
        ]);
    }

    public function show($id) 
    {
        $author = Author::query()->findOrFail($id);

        return response()->json([
            "status" => true,
            "data" => $author
        ]);

    }

    public function store(Request $request) 
    {

        $payload = $request->all();

        $author = Author::query()->create($payload);

        return response()->json([
            "status" => true,
            "message" => "Successfully created a new author",
            "data" => $author
        ]);

    }

    public function update(Request $request, $id) 
    {
        $author = Author::query()->findOrFail($id);

        $payload = $request->all();

        $author->update($payload);

        return response()->json([
            "status" => true,
            "message" => "Successfully updated the author",
            "data" => $author
        ]);

    }

    public function destroy($id)
    {
        $author = Author::query()->findOrFail($id);

        $books = Book::query()->get();

        foreach ($books as $book) {
            $book->where("author_id", $author->id)->delete();
        }

        $author->delete();

        return response()->json([
            "status" => true,
            "message" => "Successfully deleted the author",
            "data" => null
        ]);

    }

}

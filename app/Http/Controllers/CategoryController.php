<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    
    public function index()
    {

        $categories = Category::query()->get();

        return response()->json([
            "status" => true,
            "data" => $categories
        ]);
    }

    public function show($id) 
    {
        $category = Category::query()->findOrFail($id);

        return response()->json([
            "status" => true,
            "data" => $category
        ]);

    }

    public function store(Request $request) 
    {

        $payload = $request->all();

        $category = Category::query()->create($payload);

        return response()->json([
            "status" => true,
            "message" => "Successfully created a new author",
            "data" => $category
        ]);

    }

    public function update(Request $request, $id) 
    {
        $category = Category::query()->findOrFail($id);

        $payload = $request->all();

        $category->update($payload);

        return response()->json([
            "status" => true,
            "message" => "Successfully updated the author",
            "data" => $category
        ]);

    }

    public function destroy($id)
    {
        $category = Category::query()->findOrFail($id);

        $books = Book::query()->get();

        foreach ($books as $book) {
            $book->where("category_id", $category->id)->delete();
        }

        $category->delete();

        return response()->json([
            "status" => true,
            "message" => "Successfully deleted the author",
            "data" => null
        ]);

    }

}

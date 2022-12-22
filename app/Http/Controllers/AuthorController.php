<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // dd($payload);

        $validation = Validator::make($request->all(), [
            'name' =>'required|max:255',
            'email' =>'required|email|max:255',
            'gender' => 'required',
            'birthday' =>'required|date',
            'bio' => 'required',
            'photo' => 'nullable',
        ]);
        
        if($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        if($request->hasFile("photo")) {
            $payload['photo'] = $request->file("photo")->getClientOriginalName();
            $payload['photo_path'] = 'storage/' . $request->file("photo")->store("images_author", "public");
        }

        $author = Author::query()->create($payload);

        return response()->json([
            "status" => true,
            "message" => "Successfully created a new author",
            "data" => $author
        ]);

    }

    public function update(Request $request, $id) 
    {
        
        $payload = $request->all();
        
        $validation = Validator::make($request->all(), [
            'name' =>'required|max:255',
            'email' =>'required|email|max:255',
            'gender' => 'required',
            'birthday' =>'required|date',
            'bio' => 'required',
            'photo' => 'nullable',
        ]);

        if($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }
        
        $author = Author::query()->findOrFail($id);
        
        if($request->hasFile("photo")) {
            file_exists($author->photo_path) ? unlink(public_path($author->photo_path)) : false;
            $payload['photo'] = file_exists($author->photo_path) ? $author->photo : $request->file("photo")->getClientOriginalName();
            $payload['photo_path'] = file_exists($author->photo_path) ? $author->photo_path : 'storage/' . $request->file("photo")->store("images_author", "public");
        }

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
            file_exists($book->cover_path) ? 
            unlink(public_path($book->cover_path)) :
            false;
            $book->where("author_id", $author->id)->delete();
        }

        file_exists($author->photo_path) ? 
        unlink(public_path($author->photo_path)) :
        false;

        $author->delete();

        return response()->json([
            "status" => true,
            "message" => "Successfully deleted the author",
            "data" => null
        ]);

    }

}

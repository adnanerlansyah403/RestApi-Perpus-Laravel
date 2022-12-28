<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("/login", [AuthController::class, "index"])->name("login");
Route::get("/users", [AuthController::class, "getUser"])->middleware("auth:sanctum");


Route::prefix("/categories")
    ->name("categories.")
    ->middleware("auth:sanctum")
    ->group(function () {

    Route::get("/", [CategoryController::class, "index"])->name("index");
    // Route::get("/", [CategoryController::class, "create"])->name("create");
    Route::post("/store", [CategoryController::class, "store"])->name("store");
    Route::get("/{id}", [CategoryController::class, "show"])->name("show");
    Route::post("/{id}", [CategoryController::class, "update"])->name("update");
    Route::post("/{id}", [CategoryController::class, "destroy"])->name("destroy");

});

Route::prefix("/authors")
    ->name("authors.")
    ->middleware("auth:sanctum")
    ->group(function () {

    Route::get("/", [AuthorController::class, "index"])->name("index");
    // Route::get("/", [AuthorController::class, "create"])->name("create");
    Route::post("/store", [AuthorController::class, "store"])->name("store");
    Route::get("/{id}", [AuthorController::class, "show"])->name("show");
    Route::post("/{id}/update", [AuthorController::class, "update"])->name("update");
    Route::post("/{id}/destroy", [AuthorController::class, "destroy"])->name("destroy");

});

Route::prefix("/books")
    ->name("books.")
    ->middleware("auth:sanctum")
    ->group(function () {

    Route::get("/", [BookController::class, "index"])->name("index");
    // Route::get("/", [BookController::class, "create"])->name("create");
    Route::post("/store", [BookController::class, "store"])->name("store");
    Route::get("/{id}/show", [BookController::class, "show"])->name("show");
    Route::post("/{id}/update", [BookController::class, "update"])->name("update");
    Route::post("/{id}/destroy", [BookController::class, "destroy"])->name("destroy");

});

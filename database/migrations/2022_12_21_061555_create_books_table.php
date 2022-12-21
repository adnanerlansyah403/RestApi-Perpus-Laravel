<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->date("publication_at");
            $table->string("thick_of_book")->nullable();
            $table->string("size_of_book")->nullable();
            $table->string("cover")->nullable();
            $table->string("cover_path")->nullable();
            $table->string("rising_city")->nullable();
            $table->integer("age_rating")->nullable();

            $table->unsignedBigInteger("category_id")->nullable();
            $table->unsignedBigInteger("author_id")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};

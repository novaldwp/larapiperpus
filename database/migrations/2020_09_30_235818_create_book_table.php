<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_book', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('isbn')->nullable();
            $table->string('title');
            $table->year('publication_year');
            $table->longText('description')->nullable();
            $table->foreignId('category_id')->unsigned();
            $table->foreignId('publisher_id')->unsigned();
            $table->foreignId('author_id')->unsigned();
            $table->foreignId('bookshelf_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tm_book', function (Blueprint $table) {
            //
        });
    }
}

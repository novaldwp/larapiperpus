<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tp_stockin', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->integer('last_stock');
            $table->text('description');
            $table->foreignId('book_id')->unsigned();
            $table->foreignId('user_id')->unsigned();
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
        Schema::dropIfExists('tp_stockin');
    }
}

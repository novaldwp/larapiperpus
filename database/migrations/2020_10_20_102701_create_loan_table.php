<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tp_loan', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->date('return');
            $table->foreignId('book_id')->unsigned();
            $table->foreignId('member_id')->unsigned();
            $table->foreignId('user_id')->unsigned();
            $table->enum('status', ['0', '1']);
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
        Schema::dropIfExists('tp_loan');
    }
}

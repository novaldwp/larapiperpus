<?php

namespace App\Model\Main;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = "tm_book";
    protected $guarded = [];
    public $incrementing = false;
}

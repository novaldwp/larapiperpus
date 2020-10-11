<?php

namespace App\Model\Main;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $table = "tm_book";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

}

<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Bookshelf extends Model
{
    protected $table = "tm_bookshelf";
    protected $guarded = [];
    public $incrementing = false;
}

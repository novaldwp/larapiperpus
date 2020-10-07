<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bookshelf extends Model
{
    use SoftDeletes;

    protected $table = "tm_bookshelf";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}

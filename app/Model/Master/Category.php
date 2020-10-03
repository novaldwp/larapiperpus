<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "tm_category";
    protected $guarded = [];
    public $incrementing = false;
}

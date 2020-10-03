<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = "tm_publisher";
    protected $guarded = [];
    public $incrementing = false;
}

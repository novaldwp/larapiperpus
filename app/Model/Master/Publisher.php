<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publisher extends Model
{
    use SoftDeletes;

    protected $table = "tm_publisher";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}

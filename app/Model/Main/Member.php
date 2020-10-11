<?php

namespace App\Model\Main;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $table = "tm_member";
    protected $guarded = [];
    protected $dates = ['deleted_at'];
}

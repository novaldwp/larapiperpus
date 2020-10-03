<?php

namespace App\Model\Main;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = "tm_member";
    protected $guarded = [];
    public $incrementing = false;
}

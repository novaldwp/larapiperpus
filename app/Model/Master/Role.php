<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "tm_role";
    protected $guarded = [];
    public $incrementing = false;
}

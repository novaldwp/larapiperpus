<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    protected $table = "tm_author";
    protected $fillable = [
        'name', 'is_active', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];
}

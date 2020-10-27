<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Main\Book;

class Publisher extends Model
{
    use SoftDeletes;

    protected $table = "tm_publisher";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function book()
    {
        return $this->hasMany(Book::class);
    }
}

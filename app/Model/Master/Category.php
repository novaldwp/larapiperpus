<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Main\Book;
use App\Model\Master\Bookshelf;

class Category extends Model
{
    use SoftDeletes;

    protected $table = "tm_category";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function book()
    {
        return $this->hasMany(Book::class);
    }

    public function bookshelf()
    {
        return $this->hasMany(Bookshelf::class);
    }
}

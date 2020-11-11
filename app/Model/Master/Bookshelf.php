<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Master\Category;
use App\Model\Main\Book;

class Bookshelf extends Model
{
    use SoftDeletes;

    protected $table = "tm_bookshelf";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function book()
    {
        return $this->hasMany(Book::class);
    }
}

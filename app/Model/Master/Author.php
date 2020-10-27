<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Main\Book;

class Author extends Model
{
    use SoftDeletes;

    protected $table = "tm_author";
    protected $fillable = [
        'name', 'is_active', 'created_at', 'updated_at'
    ];

    protected $dates = ['deleted_at'];

    public function book()
    {
        return $this->hasMany(Book::class);
    }
}

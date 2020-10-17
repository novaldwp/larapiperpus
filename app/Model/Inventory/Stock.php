<?php

namespace App\Model\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Model\Main\Book;

class Stock extends Model
{
    protected $table = "tm_stock";
    protected $guarded = [];

    public function getCreatedAtAttribute($date)
    {
        return date('d-m-Y', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('d-m-Y', strtotime($date));
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

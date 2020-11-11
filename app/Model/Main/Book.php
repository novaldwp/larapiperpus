<?php

namespace App\Model\Main;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Inventory\Stock;
use App\Inventory\StockIn;
use App\Model\Inventory\StockOut;
use Carbon\Carbon;
use App\Model\Transaction\Loan;
use App\Model\Master\Category;
use App\Model\Master\Publisher;
use App\Model\Master\Author;
use App\Model\Master\Bookshelf;

class Book extends Model
{
    use SoftDeletes;

    protected $table = "tm_book";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function getCreatedAtAttribute($date)
    {
        return date('d-m-Y', strtotime($date));
    }

    public function getUpdatedAtAttribute($date)
    {
        return date('d-m-Y', strtotime($date));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookshelf()
    {
        return $this->belongsTo(Bookshelf::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function stockin()
    {
        return $this->hasMany(StockIn::class);
    }

    public function stockout()
    {
        return $this->hasMany(StockOut::class);
    }

    public function loan()
    {
        return $this->hasMany(Loan::class);
    }

}

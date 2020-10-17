<?php

namespace App\Model\Main;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Inventory\Stock;
use App\Inventory\StockIn;
use App\Model\Inventory\StockOut;
use Carbon\Carbon;

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

}

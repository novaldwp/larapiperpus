<?php

namespace App\Model\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Main\Book;
use App\Model\Main\Member;
use App\User;
use App\Model\Transaction\TReturn;

class Loan extends Model
{
    use SoftDeletes;

    protected $table = 'tp_loan';
    protected $guarded = [];
    protected $datesFormat = 'd-m-Y';
    protected $dates = ['deleted_at'];

    public function setReturnAttribute($value)
    {
        $this->attributes['return'] = date('Y-m-d', strtotime($value));
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function return()
    {
        return $this->hasOne(TReturn::class);
    }
}

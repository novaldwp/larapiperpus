<?php

namespace App\Model\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Model\Transaction\Loan;
use App\User;

class TReturn extends Model
{
    protected $table = "tp_return";
    protected $guarded = [];
    protected $datesFormat = "Y-m-d";

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Model\Main;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Transaction\Loan;

class Member extends Model
{
    use SoftDeletes;

    protected $table = "tm_member";
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function loan()
    {
        return $this->hasMany(Loan::class);
    }
}

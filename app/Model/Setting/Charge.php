<?php

namespace App\Model\Setting;

use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    protected $table = "td_charge";
    protected $guarded = [];
    protected $datesFormat = 'd-m-Y';
}

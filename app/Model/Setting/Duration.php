<?php

namespace App\Model\Setting;

use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    protected $table = "td_duration";
    protected $guarded = [];
    protected $datesFormat = 'd-m-Y';
}

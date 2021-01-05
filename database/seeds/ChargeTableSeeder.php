<?php

use Illuminate\Database\Seeder;
use App\Model\Setting\Charge;

class ChargeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Charge::create([
            'cost'  => 400
        ]);
    }
}

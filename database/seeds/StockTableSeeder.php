<?php

use Illuminate\Database\Seeder;
use App\Model\Inventory\Stock;

class StockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stock::create([
            'amount'    => 20,
            'book_id'   => 1
        ]);

        Stock::create([
            'amount'    => 25,
            'book_id'   => 2
        ]);

        Stock::create([
            'amount'    => 30,
            'book_id'   => 3
        ]);
    }
}

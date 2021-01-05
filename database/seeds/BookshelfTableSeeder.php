<?php

use Illuminate\Database\Seeder;
use App\Model\Master\Bookshelf;

class BookshelfTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookshelf::create([
            'name' => 'Rak 1A',
            'category_id' => '1'
        ]);

        Bookshelf::create([
            'name' => 'Rak 2 A',
            'category_id' => '1'
        ]);

        Bookshelf::create([
            'name' => 'Rak 1A',
            'category_id' => '2'
        ]);

        Bookshelf::create([
            'name' => 'Rak 1B',
            'category_id' => '2'
        ]);

        Bookshelf::create([
            'name' => 'Rak 2B',
            'category_id' => '3'
        ]);

        Bookshelf::create([
            'name' => 'Rak 1B',
            'category_id' => '3'
        ]);

    }
}

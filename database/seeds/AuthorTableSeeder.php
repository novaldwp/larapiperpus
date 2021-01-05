<?php

use Illuminate\Database\Seeder;
use App\Model\Master\Author;

class AuthorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::create([
            'name' => 'J.K Rowling'
        ]);

        Author::create([
            'name' => 'Raditya Dika'
        ]);

        Author::create([
            'name' => 'Tere Liye'
        ]);
    }
}

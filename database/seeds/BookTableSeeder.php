<?php

use Illuminate\Database\Seeder;
use App\Model\Main\Book;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::create([
            'code'  => 'BK0001',
            'isbn'  => '029928182',
            'title' => 'Buku 1',
            'image' => '1605126268.5fac487c8d1ec.jpg',
            'publication_year' => '2018',
            'description' => 'Ini adalah Buku 1',
            'category_id'   => '1',
            'publisher_id'  => '2',
            'author_id' => '1',
            'bookshelf_id'  => '2'
        ]);

        Book::create([
            'code'  => 'BK0002',
            'isbn'  => '039724112',
            'title' => 'Buku 2',
            'image' => '1609843227.5ff4421bdb84c.jpg',
            'publication_year' => '2019',
            'description' => 'Ini adalah Buku 2',
            'category_id'   => '2',
            'publisher_id'  => '3',
            'author_id' => '2',
            'bookshelf_id'  => '3'
        ]);

        Book::create([
            'code'  => 'BK0003',
            'isbn'  => '19921922212',
            'title' => 'Buku 3',
            'image' => '1609844028.5ff4453c59184.jpg',
            'publication_year' => '2020',
            'description' => 'Ini adalah Buku 3',
            'category_id'   => '3',
            'publisher_id'  => '1',
            'author_id' => '3',
            'bookshelf_id'  => '6'
        ]);
    }
}

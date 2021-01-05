<?php

use Illuminate\Database\Seeder;
use App\Model\Master\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name'  => 'Teknologi'
        ]);

        Category::create([
            'name'  => 'Hukum'
        ]);

        Category::create([
            'name'  => 'Keuangan'
        ]);
    }
}

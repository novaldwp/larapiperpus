<?php

use Illuminate\Database\Seeder;
use App\Model\Master\Gender;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gender::create([
            'name'  => 'Laki-Laki'
        ]);

        Gender::create([
            'name'  => 'Perempuan'
        ]);
    }
}

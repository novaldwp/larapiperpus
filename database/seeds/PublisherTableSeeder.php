<?php

use Illuminate\Database\Seeder;
use App\Model\Master\Publisher;

class PublisherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Publisher::create([
            'name'      => 'Gagas Media',
            'address'   => 'Jl. Gatau Dimana No. 58',
            'city'      => 'Jambi',
            'postcode'  => '11450',
            'phone'     => '02818282812'
        ]);

        Publisher::create([
            'name'      => 'PT. Elex Media Komputindo',
            'address'   => 'Gedung Kompas Gramedia, Jl. Palmerah Barat',
            'city'      => 'Jakarta',
            'postcode'  => '11480',
            'phone'     => '022771728122'
        ]);

        Publisher::create([
            'name'      => 'Yuko Media',
            'address'   => 'Jl. Bandung Bendungan',
            'city'      => 'Bandung',
            'postcode'  => '12460',
            'phone'     => '02177716272212'
        ]);
    }
}

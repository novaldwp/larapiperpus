<?php

use Illuminate\Database\Seeder;
use App\Model\Main\Member;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Member::create([
            'code'          => 'MBR2020110001',
            'first_name'    => 'Noval',
            'last_name'     => 'Dwi Putra',
            'email'         => 'nvldwiptr@gmail.com',
            'bop'           => 'Tangerang',
            'bod'           => '17-11-1995',
            'phone'         => '08992652281',
            'address'       => 'Jl. Melati Putih, Kemanggisan, Palmerah, Jakarta Barat',
            'gender_id'     => '1'
        ]);

        Member::create([
            'code'          => 'MBR2020110002',
            'first_name'    => 'Marceila',
            'last_name'     => 'Aulia',
            'email'         => 'marceil@gmail.com',
            'bop'           => 'Samarind',
            'bod'           => '14-08-1994',
            'phone'         => '081227182817',
            'address'       => 'Jl. Bojong Kolot, Ciawi, Bogor',
            'gender_id'     => '2'
        ]);

        Member::create([
            'code'          => 'MBR2020120001',
            'first_name'    => 'Ricardo',
            'last_name'     => 'Milos',
            'email'         => 'milos_ajah@gmail.com',
            'bop'           => 'Jakarta',
            'bod'           => '03-07-1996',
            'phone'         => '0819281829281',
            'address'       => 'Jl. Yang Gatau Ada Dimana, Bojong Kaler, Garut',
            'gender_id'     => '1'
        ]);
    }
}

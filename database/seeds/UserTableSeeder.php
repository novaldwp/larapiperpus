<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123'),
            'role_id' => 1
        ]);

        User::create([
            'name' => 'Petugas',
            'email' => 'petugas@petugas.com',
            'password' => Hash::make('123'),
            'role_id' => 2
        ]);
    }
}

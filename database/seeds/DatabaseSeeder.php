<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(AuthorTableSeeder::class);
        $this->call(PublisherTableSeeder::class);
        $this->call(BookshelfTableSeeder::class);
        $this->call(BookTableSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(MemberTableSeeder::class);
        $this->call(DurationTableSeeder::class);
        $this->call(ChargeTableSeeder::class);
        $this->call(StockTableSeeder::class);
    }
}

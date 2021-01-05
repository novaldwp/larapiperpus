<?php

use Illuminate\Database\Seeder;
use App\Model\Setting\Duration;

class DurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Duration::create([
            'duration'  => 4
        ]);
    }
}

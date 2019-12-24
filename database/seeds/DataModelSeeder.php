<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DataModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 10; $i < rand(1910, 2010); $i++) {
            $pairValue = ['key' => "key$i", 'value' => "value$i", 'ttl' => '5 mins', 'delete_time' => Carbon::now()->addSeconds(rand(-300, 300))->toDateTimeString()];
            App\DataModel::create($pairValue);
        }
    }
}

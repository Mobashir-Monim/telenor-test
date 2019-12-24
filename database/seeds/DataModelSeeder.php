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
        for ($i = 0; $i < rand(1900, 2000); $i++) {
            $pairValue = ['key' => "key$i", 'value' => "value$i", 'ttl' => '5 mins', 'delete_time' => Carbon::now()->addSeconds(rand(-300, 300))->toDateTimeString()];
            App\DataModel::create($pairValue);
        }
    }
}

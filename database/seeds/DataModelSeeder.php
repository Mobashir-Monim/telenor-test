<?php

use Illuminate\Database\Seeder;

class DataModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < rand(10, 100); $i++) {
            $pairValue = ['key' => "key$i", 'value' => "value$i"];
            App\DataModel::addPair($pairValue);
        }
    }
}

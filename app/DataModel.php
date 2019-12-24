<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DataModel extends Model
{
    protected $fillable = ['key', 'value', 'ttl', 'delete_time'];

    public static function addPair($pairValues)
    {
        if (!array_key_exists('ttl', $pairValues)) {
            $pairValues['ttl'] = '5 mins';
        } else {
            if (is_null($pairValues['ttl'])) {
                $pairValues['ttl'] = '5 mins';
            }
        }

        $pairValues['delete_time'] = Carbon::parse($pairValues['ttl'])->toDateTimeString();
        self::create($pairValues);

        return;
    }
}

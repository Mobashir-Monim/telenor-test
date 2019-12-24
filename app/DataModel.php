<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DataModel extends Model
{
    protected $fillable = ['key', 'value', 'ttl', 'delete_time'];

    public static function addPair($pairValues)
    {
        if (!array_key_exists('ttl', $pairValues))
            $pairValues['ttl'] = '5 mins';
        else
            if (is_null($pairValues['ttl']))
                $pairValues['ttl'] = '5 mins';

        $pairValues['delete_time'] = Carbon::parse($pairValues['ttl'])->toDateTimeString();
        self::create($pairValues);

        return;
    }

    public function resetTTL()
    {
        $this->delete_time = Carbon::now()->addMinutes(5);
        $this->save();
    }

    public function deletable()
    {
        if (Carbon::parse($this->delete_time)->diffInSeconds(Carbon::now(), false) > 300)
            return true;

        return false;
    }

    public static function removeOverTTL()
    {   
        foreach (self::all() as $item) {
            if ($item->deletable()) {
                $item->delete();
            }
        }
    }
}

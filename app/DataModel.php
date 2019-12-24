<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DataModel extends Model
{
    protected $fillable = ['key', 'value', 'ttl', 'delete_time'];

    public static function addPair($pairValues)
    {
        if (!is_null(self::where('key', $pairValues['key'])->first()))
            return 409;
        
        if (strlen($pairValues['value']) >= 16777215)
            return 413;

        if (!array_key_exists('ttl', $pairValues))
            $pairValues['ttl'] = '5 mins';
        else
            if (is_null($pairValues['ttl']))
                $pairValues['ttl'] = '5 mins';

        $pairValues['delete_time'] = Carbon::parse($pairValues['ttl'])->toDateTimeString();
        self::create($pairValues);

        return 201;
    }

    public static function updatePair($pairValues)
    {
        if (is_null(self::where('key', $pairValues['key'])->first()))
            return 404;
        
        if (strlen($pairValues['value']) >= 16777215)
            return 413;

        $pair = self::where('key', $pairValues['key'])->first();
        $pair->value = $pairValues['value'];
        $pair->save();

        return 202;
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

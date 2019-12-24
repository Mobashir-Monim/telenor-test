<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\DataModel;

class DataModelController extends Controller
{
    public function index(Request $request)
    {
        $pairValues = $this->getPairValues($request->keys);
        $this->resetTTL($pairValues);

        return response()->json([
            'status' => $this->getStatus($request->keys, $pairValues),
            'count' => count($pairValues),
            'data' => $pairValues->pluck('value', 'key')->toArray()
        ]);
    }

    public function getPairValues($keys)
    {
        DataModel::removeOverTTL();

        if (is_null($keys))
            return DataModel::all();

        return DataModel::whereIn('key', explode(',', $keys))->get();
    }

    public function getStatus($keys, $pairValues)
    {
        if (sizeof($pairValues) == 0)
            return 204;

        if (is_null($keys) || sizeof(explode(',', $keys)) == sizeof($pairValues))
            return 200;

        return 206;
    }

    public function resetTTL($pairValues)
    {
        foreach ($pairValues as $pair) {
            $pair->resetTTL();
        }
    }

    public function storePairValues(Request $request)
    {

    }
}

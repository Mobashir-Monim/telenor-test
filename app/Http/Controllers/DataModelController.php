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
        $response['status'] = $this->getStatus($request->keys, $pairValues);
        $pairValues = $pairValues->pluck('value', 'key')->toArray();
        $response = array_merge($response, $pairValues);

        return response()->json($response);
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
        foreach ($pairValues as $pair)
            $pair->resetTTL();

        return;
    }

    public function store(Request $request)
    {
        $response = array();

        foreach ($request->all() as $key => $value)
            $response[$key] = DataModel::addPair(['key' => $key, 'value' => $value]);

        return response()->json([
            'status' => 200,
            'data_status' => $response,
        ]);
    }

    public function update(Request $request)
    {
        DataModel::removeOverTTL();
        $response = array();

        foreach ($request->all() as $key => $pair)
            $response[$key] = DataModel::updatePair(['key' => $key, 'value' => $pair]);

        return response()->json([
            'status' => 200,
            'data_status' => $response,
        ]);
    }
}

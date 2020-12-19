<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Farming;
use App\SoilMoisture;
use App\Watering;

class APIController extends Controller
{
    ///___---------------___///
    ///.__ APIController __.///
    ///.._________________..///

    // *-----------------------------------------------------------------------
    // *     SOIL MOISTURE CENSOR
    // *-----------------------------------------------------------------------

    private $apiKey = 'mc.potato.app';

    // public function test(Request $request)
    // {
    //     return 'test success';
    // }

    protected function createResponse($status, $message, $data = null)
    {
        return [
            'status' => $status,
            'data' => $data,
            'message' => $message
        ];
    }
    
    public function machine_setup(Request $request)
    {
        if ($request->apiKey != $this->apiKey) return $this->createResponse(400, 'invalid api key');

        $farming = Farming::withUserPlantMachineByMachineCode($request->code);

        if (is_null($farming)) {
            return $this->createResponse(400, 'current active farming not found');
        }

        $response = [
			'farming_id' => $farming->id,
			'plant_minHumidity' => $farming->plant['minHumidity']
        ];

        return $this->createResponse(200, 'get setup data success', $response);
    }

    public function soilmoisture_store(Request $request)
    {
        if ($request->apiKey != $this->apiKey) return $this->createResponse(400, 'invalid api key');

        $soilmoisture = SoilMoisture::create([
            'value' => $request->value,
            'farming_id' => $request->farming_id
        ]);

        if (!$soilmoisture->save()) {
            return $this->createResponse(400, 'cant save soil moisture data');
        }

        return $this->createResponse(200, 'soil moisture data saved succesfully');
    }

    public function watering_store(Request $request)
    {
        if ($request->apiKey != $this->apiKey) return $this->createResponse(400, 'invalid api key');

        $wateringBefore = Watering::where('farming_id', $request->farming_id)->orderBy('start', 'desc')->first();

        if (is_null($wateringBefore->end)) {
            $wateringBefore->end = now();
            $wateringBefore->save();
        }

        $watering = Watering::create([
            'farming_id' => $request->farming_id
        ]);

        if (!$watering->save()) {
            return $this->createResponse(400, 'cant save watering data');
        }

        $response = [
            'watering_id' => $watering->id
        ];

        return $this->createResponse(200, 'watering data saved succesfully', $response);
    }

    public function watering_update(Request $request, $id)
    {
        if ($request->apiKey != $this->apiKey) return $this->createResponse(400, 'invalid api key');

        $watering = Watering::find($id);
        $watering->end = now();

        if (!$watering->save()) {
            return $this->createResponse(400, 'cant update watering data');
        }

        return $this->createResponse(200, 'watering data update succesfully');
    }
}

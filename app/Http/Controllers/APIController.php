<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SoilMoisture;

class APIController extends Controller
{
    private $apiKey = 'mc.potato.app';

    // 
    // GET
    // 

    public function get()
    {
        // use App\Farming;
        // use App\Plant;

        // $farming = Farming::where('active', true)->where('machine_id', $request->machine_id)->get();
        // $plant = Plant::find($farming->plant_id);

        // $response = [
        //     "farming_id" => $farming->id,
        //     "plant_minHumidity" => $plant->minHumidity
        // ];

        // return response()->json($response, 200);
    }

    // 
    // POST
    // 

    public function post(Request $request)
    {
        if ($request->key != $this->apiKey || !$this->attemptCreateSoilMoisture($request)) {
            return response()->json(["status" => false], 200);
        }
        
        return response()->json(["status" => true], 200);
    }

    private function attemptCreateSoilMoisture($request)
    {
        return SoilMoisture::create([
            'machine_id' => $request->machine_id,
            'value' => $request->value
        ])->save();
    }
}

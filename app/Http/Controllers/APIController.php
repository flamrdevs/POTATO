<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SoilMoisture;

class APIController extends Controller
{
    private $apiKey = 'mc.potato.app';

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

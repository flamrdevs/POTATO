<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// Added
use Storage;
use App\Weather;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Extendable Method
    
    protected function extend__weather_getArea($id)
    {
        // return if weather today exist
        $weather = Weather::where('idArea', $id)->whereDate('created_at', '=', date('Y-m-d'))->first();
        if ($weather == null) {
            $xml = Storage::get('DigitalForecast-JawaTimur.xml');
            $data = json_decode(json_encode(simplexml_load_string($xml)), true);
            $selectedArea = array_values(array_filter($data['forecast']['area'], function($area) use($id) {
                return $area['@attributes']['id'] == $id;
            }))[0];
            $attributes = array();
            $parameters = array();
            // Set Attributes
            $attributes['name'] = $selectedArea['name'][0];
            $attributes['latitude'] = $selectedArea['@attributes']['latitude'];
            $attributes['longitude'] = $selectedArea['@attributes']['longitude'];
            $attributes['coordinate'] = $selectedArea['@attributes']['coordinate'];
            $attributes['domain'] = $selectedArea['@attributes']['domain'];
            $attributes['description'] = $selectedArea['@attributes']['description'];
            // Set Parameters
            foreach ($selectedArea['parameter'] as $value) {
                $parameters[$value['@attributes']['id']] = $value;
            }
            // create weather
            Weather::create([
                'idArea' => $id,
                'attributes' => json_encode($attributes),
                'humidity' => json_encode($parameters['hu']),
                'minHumidity' => json_encode($parameters['humin']),
                'maxHumidity' => json_encode($parameters['humax']),
                'temperature' => json_encode($parameters['t']),
                'minTemperature' => json_encode($parameters['tmin']),
                'maxTemperature' => json_encode($parameters['tmax']),
                'weather' => json_encode($parameters['weather']),
            ])->save();
        } else {
            $weather->attributes = json_decode($weather->attributes, true);
            $weather->humidity = json_decode($weather->humidity, true);
            $weather->minHumidity = json_decode($weather->minHumidity, true);
            $weather->maxHumidity = json_decode($weather->maxHumidity, true);
            $weather->temperature = json_decode($weather->temperature, true);
            $weather->minTemperature = json_decode($weather->minTemperature, true);
            $weather->maxTemperature = json_decode($weather->maxTemperature, true);
            $weather->weather = json_decode($weather->weather, true);
            json_decode($weather, true);
        }
        return $weather;
    }
}

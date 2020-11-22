<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Storage;

class Weather extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'idArea',
        'attributes',
        'humidity',
        'minHumidity',
        'maxHumidity',
        'temperature',
        'minTemperature',
        'maxTemperature',
        'weather'
    ];

    ///____      ____///
    ///___ METHOD ___///
    ///____      ____///

    // Dapatkan cuaca hari ini berdasarkan id area
    public static function area($id)
    {
        $weather = Weather::where('idArea', $id)->whereDate('created_at', '=', date('Y-m-d'))->first();
        if (is_null($weather)) {
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

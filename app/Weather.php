<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Framework
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

    // * ------------------------------------------------
    // *    Methods
    // * ------------------------------------------------

    // Dapatkan cuaca hari ini berdasarkan id area
    public static function area($id)
    {
        $weather = self::where('idArea', $id)->whereDate('created_at', '=', date('Y-m-d'))->first();
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
            self::create([
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

    // Dapatkan data attributes dari return value area()
    public static function getAttributesFrom($weather)
    {
        return $weather['attributes'];
    }

    // Dapatkan data kelembaban udara 3 hari kedepan dari return value area()
    public static function getHumidityFrom($weather)
    {
        return $weather['humidity'];
    }

    // Dapatkan data minimal kelembaban udara hari ini dari return value area()
    public static function getMinHumidityFrom($weather)
    {
        return $weather['minHumidity']['timerange'][0]['value'];
    }

    // Dapatkan data maksimal kelembaban udara hari ini dari return value area()
    public static function getMaxHumidityFrom($weather)
    {
        return $weather['maxHumidity']['timerange'][0]['value'];
    }

    // Dapatkan data suhu udara 3 hari kedepan dari return value area()
    public static function getTemperatureFrom($weather)
    {
        return $weather['temperature'];
    }

    // Dapatkan data minimal suhu udara (celcius) hari ini dari return value area()
    public static function getMinTemperatureFrom($weather)
    {
        return $weather['minTemperature']['timerange'][0]['value'][0];
    }

    // Dapatkan data maksimal suhu udara (celcius) hari ini dari return value area()
    public static function getMaxTemperatureFrom($weather)
    {
        return $weather['maxTemperature']['timerange'][0]['value'][0];
    }
}

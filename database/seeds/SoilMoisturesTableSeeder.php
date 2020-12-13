<?php

use Illuminate\Database\Seeder;

use App\SoilMoisture;

class SoilMoisturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $soilmoistures = [
            ['farming_id' => 1],
            ['farming_id' => 1],
            ['farming_id' => 2],
            ['farming_id' => 2],
            ['farming_id' => 2],
            ['farming_id' => 3],
            ['farming_id' => 3],
            ['farming_id' => 3],
            ['farming_id' => 3],
            ['farming_id' => 4],
            ['farming_id' => 4],
            ['farming_id' => 4],
            ['farming_id' => 4],
            ['farming_id' => 4],
        ];

        foreach ($soilmoistures as $soilmoisture) {
            // value = 20.00 - 80.00
            $soilmoisture['value'] = mt_rand(2000,8000)/100;
            SoilMoisture::create($soilmoisture);
        }
    }
}

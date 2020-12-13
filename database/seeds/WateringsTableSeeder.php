<?php

use Illuminate\Database\Seeder;

use App\Watering;

class WateringsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $waterings = [
            ['farming_id' => 1],

            ['farming_id' => 2],

            ['farming_id' => 3],

            ['farming_id' => 4],
        ];

        foreach ($waterings as $watering) {
            Watering::create($watering);
        }
    }
}

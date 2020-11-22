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
            ['machine_id' => 'mcp.0001.11.20'],
            ['machine_id' => 'mcp.0001.11.20'],

            ['machine_id' => 'mcp.0002.11.20'],
            ['machine_id' => 'mcp.0002.11.20'],
            ['machine_id' => 'mcp.0002.11.20'],

            ['machine_id' => 'mcp.0003.11.20'],
            ['machine_id' => 'mcp.0003.11.20'],
            ['machine_id' => 'mcp.0003.11.20'],
            ['machine_id' => 'mcp.0003.11.20'],

            ['machine_id' => 'mcp.0004.11.20'],
            ['machine_id' => 'mcp.0004.11.20'],
            ['machine_id' => 'mcp.0004.11.20'],
            ['machine_id' => 'mcp.0004.11.20'],
            ['machine_id' => 'mcp.0004.11.20'],
        ];

        foreach ($soilmoistures as $soilmoisture) {
            // value = 20.00 - 80.00
            $soilmoisture['value'] = mt_rand(2000,8000)/100;
            SoilMoisture::create($soilmoisture);
        }
    }
}

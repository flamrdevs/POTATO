<?php

use Illuminate\Database\Seeder;

use App\Plant;

class PlantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plants = [
            ['name' => 'Plant A'],
            ['name' => 'Plant B'],
            ['name' => 'Plant C'],
            ['name' => 'Plant D'],
            ['name' => 'Plant E'],
        ];

        foreach ($plants as $plant) {
            // value = 20.00 - 80.00
            $plant['minHumidity'] = mt_rand(2000,3000)/100;
            Plant::create($plant);
        }
    }
}

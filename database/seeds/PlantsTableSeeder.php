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
            ['name' => 'Tanaman A'],
            ['name' => 'Tanaman B'],
            ['name' => 'Tanaman C'],
            ['name' => 'Tanaman D'],
            ['name' => 'Tanaman E'],
            ['name' => 'Tanaman F'],
            ['name' => 'Tanaman G'],
            ['name' => 'Tanaman H'],
            ['name' => 'Tanaman I'],
            ['name' => 'Tanaman J'],
        ];

        foreach ($plants as $plant) {
            // minHumidity = 20.00 - 30.00
            $plant['minHumidity'] = mt_rand(2000,3000)/100;
            Plant::create($plant);
        }
    }
}

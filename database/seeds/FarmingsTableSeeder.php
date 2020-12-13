<?php

use Illuminate\Database\Seeder;

use App\Farming;

class FarmingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $farmings = [
            ['machine_code' => 'mcodeA1', 'plant_id' => 1, 'user_id' => 1],

            ['machine_code' => 'mcodeA2', 'plant_id' => 2, 'user_id' => 2],

            ['machine_code' => 'mcodeA3', 'plant_id' => 3, 'user_id' => 3],

            ['machine_code' => 'mcodeA4', 'plant_id' => 4, 'user_id' => 4],
        ];

        foreach ($farmings as $farming) {
            Farming::create($farming);
        }
    }
}

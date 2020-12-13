<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(BroadcastsTableSeeder::class);
        $this->call(PlantsTableSeeder::class);
        $this->call(MachinesTableSeeder::class);
        $this->call(FarmingsTableSeeder::class);
        $this->call(SoilMoisturesTableSeeder::class);
        $this->call(WateringsTableSeeder::class);
    }
}
